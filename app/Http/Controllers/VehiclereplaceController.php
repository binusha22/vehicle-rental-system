<?php

namespace App\Http\Controllers;
use App\Models\Vehicle;
use App\Models\BookVehicle;
use App\Models\Vehiclebrand;
use App\Models\Carreplace;
use App\Models\Booking;
use App\Models\CustomerDeposit;
use App\Models\CustomerReg;
use App\Models\Replacedetails;
use App\Models\Customerpayment;
use App\Models\Vcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiclereplaceController extends Controller
{
    public function index(){
$cus = CustomerReg::latest()->paginate(5);
$assignEmp=Booking::where('replace_or_not',"1")->latest()->paginate(5);
$branddata= Vehiclebrand::all();
$vcat = Vcategory::all();
        $setVehicle = Vehicle::paginate(4);
        $details=Replacedetails::latest()->paginate(5);
        
        return view('inf.car_replacement',compact('setVehicle','branddata','assignEmp','details','cus','vcat'));
    }


//get customer info
    public function getCusInfo(Request $request) {
    try {
        $id = $request->input('id');
        $deposit = CustomerDeposit::where('cus_id',$id)->pluck('current_deposit')->first() ?? 0; 
        return response()->json([
            'success' => true,
            'dipo'=>$deposit
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


//insert new booking
    public function insertNewBooking(Request $request){

        $request->validate([

            'New_Invoice'=>'required',
            'Customer_Name'=>'required',
            'Phone_Number'=>'required',
            'Reason'=>'required',
            'Replaced_Vehicle_Model'=>'required',
            'Replaced_Vehicle_Number'=>'required',
            'Start_date'=>'required',
            'End_date'=>'required',
            'Amount'=>'required',
            'Milage_per_km'=>'required',
            'aggreMilage'=>'required',
            'Deposit'=>'required',
            'RestDepo'=>'required',
            'cusid'=>'required'



        ]);

        $start_date = $request->Start_date;
$end_date = $request->End_date;


//Check if there are any existing bookings that overlap with the provided date range
$overlapBooking = Booking::where('vehicle_number', $request->vehicle_number)
    ->where(function ($query) use ($start_date, $end_date) {
        $query->where(function ($query) use ($start_date, $end_date) {
            // Check if the new booking's start date falls within any existing booking's date range
            $query->where('start_date', '<=', $start_date)
                ->where('end_date', '>=', $start_date);
        })
        ->orWhere(function ($query) use ($start_date, $end_date) {
            // Check if the new booking's end date falls within any existing booking's date range
            $query->where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $end_date);
        })
        ->orWhere(function ($query) use ($start_date, $end_date) {
            // Check if any existing booking's date range falls within the new booking's date range
            $query->whereBetween('start_date', [$start_date, $end_date])
                ->orWhereBetween('end_date', [$start_date, $end_date]);
        });
    })
    ->exists();

// If overlapping booking exists, show error message
if ($overlapBooking) {
    return back()->with('f', 'Booking overlaps with existing booking for the same vehicle.');
}

                    try {
        $statusValue = "booked";
        $currentDate = now()->toDateString();
        $currentTimestamp = now();

        $data = [
            'invoice_number' => $request->New_Invoice,
            'vehicle_number' => $request->Replaced_Vehicle_Number,
            'vehicle_name' => $request->Replaced_Vehicle_Model,
            'customer_id'=> $request->cusid,
            'customer_name' => $request->Customer_Name,
            'mobile' => $request->Phone_Number,
            'start_date' => $request->Start_date,
            'end_date' => $request->End_date,
            'status' => $statusValue,
            'reg_date' => $currentDate,
            'additonal_cost_km'=>$request->Milage_per_km,
            'agreedmile'=>$request->aggreMilage,
            'amount'=>$request->Amount,
            'replace_or_not'=>"1",
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp
        ];

        // Check if Id_Number is provided and add it to the $data array
        if ($request->has('Id_Number')) {
            $data['cus_id'] = $request->Id_Number;
        }
        // Check if Passport_Number is provided and add it to the $data array
        if ($request->has('Passport_Number')) {
            $data['cus_passport'] = $request->Passport_Number;
        }
        
        // Update CustomerDeposit
        $sendDeposit = [
            'invoice' => $request->New_Invoice,
            'current_deposit' => $request->RestDepo
        ];
        // CustomerDeposit::where('cus_id', $request->cusid)->update($sendDeposit);

        //Start a database transaction
        DB::transaction(function () use ($data) {
            // Insert data into Booking table
            Booking::insert($data);
        });

        // Create entry in BookVehicle table
        $num = Vehicle::where('vehicle_number', $request->Replaced_Vehicle_Number)->pluck('id')->first();
        $bookVehicleData = [
             'vid' => $num,
             'startdate' => $request->Start_date, 
             'enddate' => $request->End_date
        ];
        BookVehicle::create($bookVehicleData);
        // Customerpayment::where('customer_id',$request->cusid)->where('status',"pending")->update(['deposit'=>$request->RestDepo]);
        // Update Customerpayment
        $finalpaymentdata = [
            'invoice_number' => $request->New_Invoice, 
            'vehicle_number' => $request->Replaced_Vehicle_Number, 
            'customer_id' => $request->cusid,
            'customer_name' => $request->Customer_Name,
            'start_date' => $request->Start_date, 
            'end_date' => $request->End_date, 
            'trip_amount' => $request->Amount,
            'deposit' => $request->Deposit,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        
        // Check if Id_Number is provided and add it to the $finalpaymentdata array
        if ($request->has('Id_Number')) {
            $finalpaymentdata['id_number'] = $request->Id_Number;
        }
        // Check if Passport_Number is provided and add it to the $finalpaymentdata array
        if ($request->has('Passport_Number')) {
            $finalpaymentdata['passport_number'] = $request->Passport_Number;
        }
        Customerpayment::create($finalpaymentdata);

         //dd($finalpaymentdata);
        return back()->with('s', 'Data added successfully');
    } catch (\Throwable $th) {
                    // Log or handle the exception appropriately
                    dd($th);
                    return back()->with('f', 'Error, Data could not be added');
                }
                   

  
    }




                    // event(new BookingUpdated($data));
                    // $replaceDetails=[
                    //      'new_inv'=>$request->New_Invoice, 
                    //      'old_inv'=>$request->Old_Invoice ,
                    //      'cus_name'=>$request->Customer_Name ,
                    //       'cus_id'=>$request->Id_Number ,
                    //        'passport'=>$request->Passport_Number ,
                    //         'reg_date'=>$currentDate, 
                    //         's_date'=>$request->Start_date, 
                    //          'e_date'=>$request->End_date,
                    //          'old_v_number'=>$request->Old_Vehicle_Number ,
                    //           'new_v_number'=>$request->Replaced_Vehicle_Number, 
                    //           'trip_amount'=>$request->Amount,
                    //           'additional_cost_km'=>$request->Milage_per_km,
                    //           'rest_of_deposit'=>$request->RestDepo,
                    //           'created_at' => $currentTimestamp,
                    //     'updated_at' => $currentTimestamp

                    // ];
                    //Replacedetails::insert($replaceDetails);
//search replace 
    public function search(Request $request)
{

    $search2 = $request->input('searchReplace');
    

    $query = Carreplace::query();
    $query->where('status', 'pending');
   
    if ($search2) {
        $query->where(function ($subquery) use ($search2) {
            $subquery->where('invoice', 'like', "%{$search2}%")
                ->orWhere('vehicle_number', 'like', "%{$search2}%");
        });
    }

     $booking = $query->latest()->get(); // Paginate the results with 5 items per page

    return response()->json(['data' => $booking]);
}
















}
