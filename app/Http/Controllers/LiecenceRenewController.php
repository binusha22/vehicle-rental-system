<?php

namespace App\Http\Controllers;
use App\Models\liecence_renew;
use App\Models\OwnerPayment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicleregister;
use Carbon\Carbon;

class LiecenceRenewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request)
{
    $search = $request->input('search');
    $currentDate = now()->toDateString(); // Get the current date
    
    // Retrieve records with expire_date equal to the current date
    $vehiclesCurrentDate = liecence_renew::whereDate('expire_date', $currentDate)->orderBy('expire_date', 'asc')->get();
    
    $query = liecence_renew::query();

    if ($search) {
        $query->orWhere('vehicle_number', 'like', '%' . $search . '%');
    }
    
    // Exclude records with expire_date equal to the current date
    $query->whereDate('expire_date', '!=', $currentDate);
    
    // Retrieve the remaining records
    $vehiclesRemaining = $query->orderBy('expire_date', 'asc')->get();

    // Merge the two sets of records, with current date records at the top
    $vehicles = $vehiclesCurrentDate->concat($vehiclesRemaining);

    $renewSummery = liecence_renew::latest()->orderBy('expire_date', 'desc')->get(); // Use get() instead of paginate()
    
    return view('inf.car_liecence', compact('vehicles', 'search', 'renewSummery'));
}

 
    
     public function searchVehicles(Request $request)
     {
         
     }

     //inset data into database
     public function insertVehicleRenew(Request $request){

        $validatedData = $request->validate([
            'vehicle_name' => 'required',
            'vehicle_number' => 'required',
            'renewed_date' => 'required',
            'expire_date' => 'required',
            'renew_cost'=> 'required'
        ]);
        try{
        // Create a new LiecenceRenew instance
        $insertRenew = new liecence_renew();
        
        // Use updateOrCreate to either update an existing record or create a new one
        $insertRenew->updateOrCreate(
            ['id' => $request->vehicle_id, 
            'vehicle_number' => $request->vehicle_number],
            [
                'vehicle_name' => $request->vehicle_name,
                'renewed_date' => $request->renewed_date,
                'expire_date' => $request->expire_date,
                'renew_cost' => $request->renew_cost
                // Add other fields as needed
            ]
        );

        $currentYearMonthDay = Carbon::now()->format('Y-m-d');
        $updateOwnerpay=[
                'liesence_renew_date'=>$currentYearMonthDay, 
                'liesence_renew_cost'=>$request->renew_cost

        ];
        OwnerPayment::where('vnumber',$request->vehicle_number)->update($updateOwnerpay);
        //update liecence last update column
        // Vehicleregister::where('id', $request->vehicle_id)
        // ->update(['liec_last_update' => now()->toDateString()]);

            $renewSummery = liecence_renew::latest()->orderBy('expire_date', 'desc')->get();
            return back()->with(['success' => 'Data inserted successfully', 'renewSummery' => $renewSummery]);
} catch (\Exception $e) {
    return back()->with(['error' => 'Failed to insert data']);
}
    
    
     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
