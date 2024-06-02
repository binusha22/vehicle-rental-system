<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OwnerPayment;
use App\Models\Servicecost;
use App\Models\Ownerpaydetails;

class OwnerpayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $st="unpaid";
        // Retrieve data where the month and year of previous_pay_date match the current month and year
        $paymentsThisMonth = OwnerPayment::where('status', $st)->get();


        $paymentDetails = Ownerpaydetails::orderBy('id', 'desc')->paginate(10);
        return view('inf.owner_payment',compact('paymentsThisMonth','paymentDetails'));
    }
//filter data in table

    public function filterPayments(Request $request)
    {
        $ownerName = $request->input('owner_name');
        $paymentDate = $request->input('payment_date');

        $query = OwnerPayment::query();

        if ($ownerName) {
            $query->where('owner_name', 'LIKE', '%' . $ownerName . '%');
        }

        if ($paymentDate) {
            $date = Carbon::createFromFormat('Y-m', $paymentDate);
            $query->whereMonth('previous_pay_date', $date->month)
                  ->whereYear('previous_pay_date', $date->year);
        }

        $payments = $query->get();

        return response()->json($payments);
    }

    //filter service cost data
   public function filterserviceCost(Request $request)
{
    $vnumber = $request->input('inv');
    
    // Get the current month
    $currentMonth = date('m');
    
    // Fetch data where the month of the "date" column matches the current month
    $data = Servicecost::where('vnumber', $vnumber)
                       ->where('status', 'complete')
                       ->whereRaw('MONTH(date) = ?', [$currentMonth])
                       ->get();
    
    // Calculate the sum of the 'cost' column for the filtered data
    $dataSumt = Servicecost::where('vnumber', $vnumber)
                           ->where('status', 'complete')
                           ->whereRaw('MONTH(date) = ?', [$currentMonth])
                           ->sum('cost');

    return response()->json(['data' => $data, 'dataSumt' => $dataSumt]);
}

    public function create()
    {
        //
    }

//send data to owner payment details table
    public function store(Request $request)
    {
        try{
        $request->validate([

                'owner_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:15',
        'vehicle_number' => 'required|string|max:20',
        'vehicle_name' => 'required|string|max:255',
        'agreed_miledge' => 'required|numeric',
        'agreed_payment' => 'required|numeric',
        'previous_milage' => 'required|numeric',
        'fees_for_maintain' => 'required|numeric',
        'fees_for_liesence' => 'required',
        'new_miledge' => 'required|numeric',
        'actual_milage' => 'required|numeric',
        'additonal_milage' => 'required|numeric',
        'charge_for_additonal_per_1km' => 'required|numeric',
        'total_additional_cost' => 'required|numeric',
        'monthly_payment' => 'required|numeric',

        ]);
        $currentYearMonthDay = Carbon::now()->format('Y-m-d');

        

        $ownerPay = new Ownerpaydetails();

        $ownerPay->vnumber = $request->input('vehicle_number');
        $ownerPay->vname = $request->input('vehicle_name');
        $ownerPay->owner_name = $request->input('owner_name');
        $ownerPay->phone_number = $request->input('contact_number');
        $ownerPay->agreed_miledge = $request->input('agreed_miledge');//
        $ownerPay->agreed_payment = $request->input('agreed_payment');//
        $ownerPay->liesence_renew_cost = $request->input('fees_for_liesence'); 
        $ownerPay->liesence_renew_date = $request->input('lrn_date'); 
        $ownerPay->maintain_cost= $request->input('fees_for_maintain');
        $ownerPay->new_mile= $request->input('actual_milage');
        $ownerPay->monthly_amount= $request->input('monthly_payment');
        $ownerPay->previous_mile = $request->input('previous_milage');
        $ownerPay->additional_mile = $request->input('additonal_milage');
        $ownerPay->km_cost_additi_mile= $request->input('charge_for_additonal_per_1km');
        $ownerPay->total_additio_cost =$request->input('total_additional_cost');
        $ownerPay->previous_pay_date = $currentYearMonthDay;

        $ownerPay->save();


        $ad=OwnerPayment::where('vnumber',$request->vehicle_number)->pluck('additional_mile')->first();
        $updateOwnerpay=[
                'previous_mile'=>$request->new_miledge,
                'previous_pay_date'=>$currentYearMonthDay,
                'additional_mile'=>$ad+$request->additonal_milage,
                'status'=>"paid"

        ];

        $condi=[

                'vnumber'=>$request->vehicle_number
        ];

        OwnerPayment::where($condi)->update($updateOwnerpay);

        return back()->with('s', 'successfully added the data');
     } catch (\Throwable $th) {
                   dd($th);
              return back()->with('f', 'Error, Data could not be added');
           }

    }


public function filterservicedetails(Request $request)
{
    $ownerName = $request->input('owner_name');
    $paymentDate = $request->input('previous_pay_date');

    $query = Ownerpaydetails::query();

    if ($ownerName) {
        $query->where('owner_name', 'LIKE', '%' . $ownerName . '%');
    }

    if ($paymentDate) {
        $query->whereMonth('previous_pay_date', '=', Carbon::parse($paymentDate)->month)
              ->whereYear('previous_pay_date', '=', Carbon::parse($paymentDate)->year);
    }

    $data = $query->get();
    

    return response()->json(['data' => $data]);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
