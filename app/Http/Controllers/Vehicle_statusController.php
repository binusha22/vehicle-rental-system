<?php

namespace App\Http\Controllers;
use App\Models\Vehicleregister;
use App\Models\Vehicle_status;
use App\Models\VehicleAvaorUna;
use Illuminate\Http\Request;
use App\Models\Vehicle_reg_mielage;
use App\Services\VehicleService;

class Vehicle_statusController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }
    public function index(Request $request){
        $search = $request->input('search');
        $renewedDate = $request->input('renewed_date');
        
        $query = Vehicle_status::query();
    
        if ($search) {
            $query->orWhere('vehicle_number', 'like', '%' . $search . '%');
        }
    
        if ($renewedDate) {
            // Adjust this condition based on your database column for 'renewed_date'
            $query->Where('in_date', '=', $renewedDate);
        }

        $vehicleStatus = $query->latest()->paginate(10);
        $data=Vehicle_status::where('reason', 'Yard in')->get();
        $dataOut=Vehicle_status::where('reason','!=','Yard in')->get();
        
        return view('inf.car_status',['data'=>$data,'dataOut'=>$dataOut,'vehicleStatus'=>$vehicleStatus,'search'=>$search ]);
        
    }
    ///search data



    
//load data 
public function loadData($vehicle_id){
    $vehicle = Vehicle_reg_mielage::where('vehicle_number', $vehicle_id)->get();

    return response()->json($vehicle);
}



//insert data
public function insertDetails(Request $request){
        $request->validate([
            'vehicle_number' => 'required',
            'vehicle_id' => 'required',
            'vehicle_name' => 'required',
            'out_mileage' => 'required',
            'out_date' => 'required',
            'reason' => 'required',
        ]);
    
        // Check if a record with the specified condition exists
        $existingRecord = Vehicle_status::where('vehicle_number', $request->vehicle_number)
            ->where('reason', '!=', 'Yard in')
            ->first();
    
        if ($existingRecord) {
            // A record with a reason other than 'Yard in' exists, notify the user
            return back()->with('f1', 'Error, You cant make a vehicle out request ');
        }
    
        $data = [
            'vehicle_id' => $request->vehicle_id,
            'vehicle_name' => $request->vehicle_name,
            'out_mileage' => $request->out_mileage,
            'out_date' => $request->out_date,
            'reason' => $request->reason,
        ];
        $st="unavailable";
        $bs="On going";
        $updateVA=[
            'vehicle_status' => $st ,
            'reason'=>$request->reason,
            'booking_status'=>$bs
        ];
    
        // Use updateOrInsert to either update an existing row or insert a new row
        Vehicle_status::updateOrInsert(['vehicle_number' => $request->vehicle_number], $data);
        $this->vehicleService->currentStatusadding($request, $request->vehicle_name, $request->vehicle_number,$request->reason);
        VehicleAvaorUna::where('vehicle_number',$request->vehicle_number)->update($updateVA);







        return back()->with('s1', 'Data added successfully');
    }
    
    


    public function insertDetails2(Request $request){
        $request->validate([
            'vehicle_number2' => 'required',
            'vehicle_id2' => 'required',
            'vehicle_name2' => 'required',
            'in_mileage2' => 'required',
            'in_date' => 'required',
            'reason2' => 'required',
        ]);
    
        $condition = [
            'vehicle_number' => $request->vehicle_number2,
            'reason' => 'Yard in', // Add the condition for 'Yard in' in the 'reason' column
        ];
    
        // Check if a record with the specified condition exists
        $existingRecord = Vehicle_status::where($condition)->first();
    
        if ($existingRecord) {
            // Record with 'Yard in' reason already exists, notify the user
            return back()->with('f', 'Error, You cant make a vehicle in request');
        }
    // If the record doesn't exist, fetch the latest 'out_mileage'
    $latestOutMileageRecord = Vehicle_status::where('vehicle_number', $request->vehicle_number2)
        ->first();

    $outMileage = $latestOutMileageRecord ? $latestOutMileageRecord->out_mileage : 0;
    $inMileage = $request->in_mileage2;

    $totalMileage = $inMileage - $outMileage;




        $data = [
            
            'vehicle_name' => $request->vehicle_name2,
            'in_mileage' => $request->in_mileage2,
            'in_date' => $request->in_date,
            'reason' => $request->reason2,
            'trip_mileage' => $totalMileage
        ];
    $st="available";
        $bs="No Bookings";
        $zero="0";
        $updateVA=[
            'vehicle_status' => $st ,
            'reason'=>$request->reason2,
            'booking_status'=>$bs,
            'book_date'=>$zero,
            'release_date'=>$zero
        ];
        $vehiUpdata=[
            'newMiledge'=>$request->in_mileage2
        ];
        $vehimileupdata=[
            'mielage'=>$request->in_mileage2
        ];
        $condi=[
            'vehicle_number' => $request->vehicle_number2
        ];
        
        // Use updateOrInsert to either update an existing row or insert a new row
        Vehicle_status::where('vehicle_number',$request->vehicle_number2)->update($data);
    VehicleAvaorUna::where('vehicle_number',$request->vehicle_number2)->update($updateVA);
    Vehicleregister::where($condi)->update($vehiUpdata);
        Vehicle_reg_mielage::where($condi)->update($vehimileupdata);
        $this->vehicleService->currentStatusadding($request, $request->vehicle_name2, $request->vehicle_number2,$request->reason2);
        return back()->with('s', 'Data added successfully');
    }
    


    public function filterVehicleReason(Request $request)
{
    $reason = $request->input('reason');
    $data = Vehicle_status::where('reason', $reason)->get();

    return response()->json(['data' => $data]);
}

}
