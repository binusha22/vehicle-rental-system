<?php

namespace App\Http\Controllers;
use App\Models\InsuRenew;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicleregister;


class InsuRenewController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search2');
    $currentDate = now()->toDateString(); // Get the current date
    
    // Retrieve records with expire_date equal to the current date
    $vehiclesCurrentDate = InsuRenew::whereDate('expire_date', $currentDate)->orderBy('expire_date', 'asc')->get();
    
    $query = InsuRenew::query();

    if ($search) {
        $query->orWhere('vehicle_number', 'like', '%' . $search . '%');
    }
    
    // Exclude records with expire_date equal to the current date
    $query->whereDate('expire_date', '!=', $currentDate);
    
    // Retrieve the remaining records
    $vehiclesRemaining = $query->orderBy('expire_date', 'asc')->get();

    // Merge the two sets of records, with current date records at the top
    $vehicles = $vehiclesCurrentDate->concat($vehiclesRemaining);

    $renewSummery = InsuRenew::latest()->orderBy('expire_date', 'desc')->get(); // Use get() instead of paginate()
    
    return view('inf.car_insurence', compact('vehicles', 'search', 'renewSummery'));
}


    //inset data into database
    public function insertVehicleRenew(Request $request){

        $validatedData = $request->validate([
            'vehicle_name' => 'required',
            'vehicle_number' => 'required',
            'renewed_date' => 'required',
            'expire_date' => 'required'
        ]);
        try{
        // Create a new LiecenceRenew instance
        $insertRenew = new InsuRenew();
        
        // Use updateOrCreate to either update an existing record or create a new one
        $insertRenew->updateOrCreate(
            ['id' => $request->vehicle_id, 'vehicle_number' => $request->vehicle_number],
            [
                'vehicle_name' => $request->vehicle_name,
                'renewed_date' => $request->renewed_date,
                'expire_date' => $request->expire_date,
                // Add other fields as needed
            ]
        );
        // Vehicleregister::where('id', $request->vehicle_id)
        // ->update(['insu_last_update' => now()->toDateString()]);
                $renewSummery = InsuRenew::latest()->orderBy('expire_date', 'desc')->get();;
                return back()->with(['success' => 'Data inserted successfully', 'renewSummery' => $renewSummery]);
    
            } catch (\Exception $e) {
                return back()->with(['error' => 'Failed to insert data']);
            }
    
     }

   
}
