<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Customerpayment;
use App\Models\CustomerDeposit;
use App\Models\Vehicleregister;
use App\Models\Carreplace;

class CustomerpayController extends Controller
{
   public function index(){
    
$bookData = Booking::where('status', 'On going')
                    ->where('pay_status', '0')
                    ->orderByRaw('CASE 
                                     WHEN start_date <= CURDATE() - INTERVAL 2 DAY THEN 0
                                     ELSE 1
                                  END')
                    ->orderBy('start_date')
                    ->paginate(7);

    $completeBook = Customerpayment::where('status', 'completed')->latest()->paginate(7);
    $invonumbers = Booking::where('status', 'On going')->where('pay_status', '0')->pluck('invoice_number');


    $invonumbersSecond = Customerpayment::where('status', 'completed')->pluck('invoice_number');
    $pending_final_stage=Customerpayment::where('status', 'pending')->paginate(7);
    return view('inf.customer_payment', compact('bookData', 'invonumbers', 'completeBook', 'invonumbersSecond','pending_final_stage'));
}
//get deposit
public function fetchDeposit(Request $request)
{
    try {
        $invoice = $request->input('invoice');
        $deposit = CustomerDeposit::where('cus_id', $invoice)->pluck('current_deposit')->first() ?? 0; // Assuming 'invoice' is the column name in the CustomerDeposit table

        return response()->json([
            'success' => true,
            'deposit' => $deposit
        ]);
    } catch (\Exception $e) {
        // If an error occurs, report the error and return error response
        report($e);
        return response()->json([
            'success' => false,
            'message' => 'Error occurred while fetching deposit data.'
        ], 500); // Internal Server Error
    }
}

//get miledde/cost
public function fetchMiledge(Request $request)
{
    try {
        $invoice = $request->input('invoice');
        $data = Booking::where('invoice_number', $invoice)->first(); 

        if ($data) {
            $additionalMile = $data->additinalMile ?? 0;
            $additionalCostKm = $data->additonal_cost_km ?? 0;
            $totalCost = $additionalMile * $additionalCostKm;

            return response()->json([
                'success' => true,
                'data' => [
                    'additionalMile' => $additionalMile,
                    'additional_cost_km' => $additionalCostKm,
                    'totalcost' => $totalCost
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the provided invoice.'
            ], 404);
        }
    } catch (\Exception $e) {
        report($e);
        return response()->json([
            'success' => false,
            'message' => 'Error occurred while fetching mileage data.'
        ], 500);
    }
}




    //get and send data to customer payemt table
    public function insertData(Request $request){

try{
        $request->validate([
            'invoice_number'=>'required|unique:customerpayments,invoice_number',
            'customer_name'=>'required',
            'vehicle_number'=>'required',
            'id_number'=>'required',
            'passport_number'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            // 'agreed'=>'required',
            // 'trip_milage'=>'required',
            // 'additional_milage'=>'required',
            // 'additional_cost_per_km'=>'required',
            // 'additional_milage_cost'=>'required',
            'trip_amount'=>'required',
            'advance'=>'required',
             'to_pay'=>'required',
             'deposit'=>'required'

             // 'final_amount'=>'required',




        ]);
        $sts="pending";
        $currentDate = now()->toDateString();
        $data=[
            'invoice_number' =>$request->invoice_number, 
            'vehicle_number' =>$request->vehicle_number, 
            'customer_id'=>$request->cusid,
            'customer_name'=> $request->customer_name,  
            'id_number'=> $request->id_number,
            'passport_number'=>$request->passport_number, 
            'start_date'=>$request->start_date , 
            'end_date'=>$request->end_date , 
            'trip_amount'=>$request->trip_amount, 
             
            //  'additional_milage_cost'=>$request->additional_milage_cost,
            //   'final_amount'=>$request->final_amount, 
            //     'payment_date' => $currentDate,
            'deposit'=>$request->deposit,
                'status'=>$sts,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

        ];
        $bookStatuschange="1";
            $condition=['invoice_number' => $request->invoice_number];
            Customerpayment::create($data);
            Booking::where($condition)->update(['pay_status' => $bookStatuschange]);
         return back()->with('s', 'successfully added data');

    } catch (Exception $e) {
        return back()->with('f', 'Could not add the data');
    }
 
    }

//insert final payment
    public function insertfinalpay(Request $request){

        $request->validate([
            'invoice_number2'=>'required',
            'customer_name2'=>'required',
            'vehicle_number2'=>'required',
            'start_date2'=>'required',
            'end_date2'=>'required',
            'trip_amount2'=>'required',
            'additional_milage2'=>'required',
            'additional_cost_per_km2'=>'required',
            'additional_milage_cost2'=>'required',
            'final_amount'=>'required',
            'depositsec'=>'required',
            'restDepo'=>'required',

        ]);
        try{
            $val=$request->checkVal;
           
                $currentDate = now()->toDateString();
                $updateFinalpay = [
                    'additional_milage' => $request->additional_milage2,
                    'additional_milage_cost' => $request->additional_cost_per_km2,
                    'final_amount' => $request->final_amount, 
                    'payment_date' => $currentDate,
                    'damage_fee' => $request->damage_fee,
                    'deposit' => $request->depositsec,
                    'rest_of_deposit' => $request->restDepo
                ];
                $bookStatuschange = "completed";

                Customerpayment::where('invoice_number', $request->invoice_number2)->update(['status' => $bookStatuschange] + $updateFinalpay);

                    Booking::where('invoice_number', $request->invoice_number2)->update(['status' => $bookStatuschange]);
                


                if ($request->has('useRestDepo')) {
                   CustomerDeposit::where('invoice', $request->invoice_number2)->update(['deposit' => 0, 'current_deposit' => 0])
                } else {
                    

                }
                return back()->with('s', 'successfully added data');

                } catch (Exception $e) {
        return back()->with('f', 'Could not add the data');
    }

        
    }


    //edit cutomer to pay
    public function edit_topay(Request $request){

$request->validate([
    'addAmount'=>'required'
]);
       $inv = $request->getInvo;
       $amount=$request->addAmount;
       $newTopay=$request->getEditedTopay;

$data = Booking::where('invoice_number', $inv)->select('advanced', 'rest')->first();

if ($data) {
   
    $advanced = $data->advanced;
    $rest = $data->rest;

    $updateDAta=[

        'advanced'=>$advanced+$amount,
        'rest'=>$newTopay
    ];

Booking::where('invoice_number', $inv)->update($updateDAta);
 return back()->with('s', 'updated the advanced and rest of payment');
    
} else {
    return back()->with('f', 'Error, no data found for the provided invoice number');
}


        return back();
    }

//load invoice and get data
    public function loadInvoice(Request $request){
    $inv = $request->input('inv');

    $query = Booking::query();

    if ($inv) {
        $query->where('invoice_number', $inv);
        // Add status equal to 'pending' to this query 
        $query->where('status', 'On going');
        $query->where('pay_status', '0');
    }

    $data = $query->get();

    return response()->json(['data' => $data]);
}

public function loadcuspay(Request $request){
    $inv = $request->input('invsecond');

    $query = Customerpayment::query();

    if ($inv) {
        $query->where('invoice_number', $inv);
        
    }

    $data = $query->get();

    return response()->json(['data' => $data]);
}


}




