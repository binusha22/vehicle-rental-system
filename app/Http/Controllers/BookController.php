<?php

namespace App\Http\Controllers;
use App\Models\VehicleAvaorUna;
use App\Models\Vehiclebrand;
use App\Models\Vehiclecategory;
use App\Models\CustomerReg;
use App\Models\Booking;
use App\Models\Attendence;
use App\Models\VehicleRegister;
use App\Models\User;
use App\Models\Vcategory;
use App\Models\CustomerDeposit;
use App\Models\Task;
use App\Models\Vehicle;
use App\Models\DashBoardvehicle;
use App\Models\BookVehicle;
use App\Models\Customerpayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Notifications\TaskNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Events\BookingUpdated;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;




class BookController extends Controller
{
    public function index(){

        

        $branddata= Vehiclebrand::all();
       $cus = CustomerReg::latest()->get();
        $vcat = Vcategory::all();

        $st="available";
        
        $setVehicle = Vehicle::latest()->get();

        $booking = Booking::orderBy('start_date', 'asc')->where('status','On going')->orwhere('status','booked')->paginate(10);



        
    return view('inf.car_booking',['setVehicle'=>$setVehicle,'branddata'=>$branddata,'cus'=>$cus,'booking'=>$booking,'vcat'=>$vcat]);
    }
    //second book
    public function second_book(){
         return view('inf.car_booking_second');
    }
//sse intergration
    public function sse(Request $request)
    {
        return new StreamedResponse(function () {
            while (true) {
                $bookings = Booking::latest()->orderBy('created_at', 'desc')->get();


            // Set the appropriate headers for SSE
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
                // Send SSE message containing bookings data to the client
                echo "data: " . json_encode($bookings) . "\n\n";
                ob_flush();
                flush();

                // Simulate a delay before sending the next message
                sleep(1);
            }
        });
    }

//generate invoice number
public function generateInvoiceNumber()
{
    $latestBooking = Booking::latest('id')->first();
    $currentYearMonthDay = Carbon::now()->format('Ymd');

    if ($latestBooking) {
        // Increment the last invoice number
        $lastInvoiceNumber = $latestBooking->invoice_number;
        $lastNumber = intval(substr($lastInvoiceNumber, -1));
        $newInvoiceNumber = 'inv' . $currentYearMonthDay . ($lastNumber + 1);
    } else {
        // First invoice number for the day
        $newInvoiceNumber = 'inv' . $currentYearMonthDay . '1';
    }

    // Store the generated invoice number in the session
    

    return $newInvoiceNumber;
}

    //load models
public function loadModel($brandId, $vcat)
{
    $models = Vehiclecategory::where('brand2', $brandId)->where('vcat', $vcat)->get(); // Adjust the fields as necessary

    return response()->json($models);
}


//extend vehicle
public function extend_booking(Request $request){

$request->validate([

'totalExtend'=>'required',
'agromile'=>'required',
'extendEnddate'=>'required'

],[
'totalExtend'=>'please add the new Trip amount',
'extendEnddate'=>'please add the end date'
]);

try{
    $inv=$request->invExtend;
    $enddate=$request->extendEnddate;
    $amount=$request->totalExtend;
    $agriMile=$request->agromile;
    //$getCusid=

    
    $preAmount = 0;
$agreedMile = 0;
    $bookingData = Booking::where('invoice_number', $inv)->first();

    if ($bookingData) {
    $preAmount = $bookingData->amount;
    $agreedMile = $bookingData->agreedmile;
} else {
    return back()->with('f', 'Error, there is no matching invoice number');
}


$newAmount = $amount + $preAmount;
$newAgreedMile = $agriMile + $agreedMile;
   

$extendCondition=[
    'invoice_number'=>$inv,
];

$extendData = [
    'end_date' => $enddate,
    'amount' => $newAmount,
    'agreedmile' => $newAgreedMile
];


    //update deposit table

            $depos = CustomerDeposit::where('cus_id', $request->getCusid)->firstOrFail();

            $depositTable=$depos->current_deposit;

            $rest=$depositTable-$amount;
            
            $condition=[
                    'cus_id'=>$request->getCusid
            ];

            $deposiData=[
                'current_deposit'=>$rest
            ];



$num=Vehicle::where('vehicle_number',$request->vehinum)->pluck('id')->first();

                    $data=[
                         'vid'=>$num ,
                         'startdate'=>$request->extendStartdate, 
                         'enddate'=>$request->extendEnddate
                    ];



 
        $currentDate = now()->toDateString();
        $dataSet=[
            
            'end_date'=>$request->extendEnddate , 
            'trip_amount'=>$newAmount

        ];
        
        $bookStatuschange="On going";
            Booking::where($extendCondition)->update(['status' => $bookStatuschange] + $extendData);
            BookVehicle::create($data);
            
    
            if ($request->has('useRestDepo')) {
            $dataSetSecond=[
            
            'end_date'=>$request->extendEnddate , 
            'trip_amount'=>$newAmount, 
            'deposit'=>$rest

        ];
            CustomerDeposit::where($condition)->update($deposiData);
            Customerpayment::where('invoice_number', $inv)->update($dataSetSecond);
            }else{
                Customerpayment::where('invoice_number', $inv)->update($dataSet);
            }
            

            return back()->with('s', 'successfully updated the booking');
     } catch (\Throwable $th) {
                   dd($th);
                    return back()->with('f', 'Error, Data could not be added');
                }
}

public function fetchDataFromVehicleRegister(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');

        // Fetch data from the VehicleRegister model based on brand and model
        $data = Vehicle::where('brand', $brand)
                               ->where('model', $model)
                               ->get();

        return response()->json($data);
    }

public function getAvailableVehicle(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $brand = $request->input('brand');
    $model = $request->input('model');
    $vcat = $request->input('vcat');

    $availableVehiclesQuery = Vehicle::whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
        $query->where(function ($query) use ($startDate, $endDate) {
            $query->where('startdate', '>=', $startDate)
                  ->where('startdate', '<=', $endDate);
        })->orWhere(function ($query) use ($startDate, $endDate) {
            $query->where('enddate', '>=', $startDate)
                  ->where('enddate', '<=', $endDate);
        })->orWhere(function ($query) use ($startDate, $endDate) {
            $query->where('startdate', '<=', $startDate)
                  ->where('enddate', '>=', $endDate);
        });
    });

    if (!empty($vcat)) {
        $availableVehiclesQuery->where('vcat', $vcat);
    }

    if (!empty($brand)) {
        $availableVehiclesQuery->where('brand', $brand);
    }

    if (!empty($model)) {
        $availableVehiclesQuery->where('model', $model);
    }

    $availableVehicles = $availableVehiclesQuery->get();

    return response()->json($availableVehicles);
}





    //fetch customers details
public function fetchFilteredData(Request $request)
{
    $search_cus = $request->input('search_cus');
    $search_cus_id = $request->input('search_cus_id');
    $search_cus_number = $request->input('search_cus_number');

    $query = CustomerReg::query();

    if ($search_cus) {
        $query->where(function ($subquery) use ($search_cus) {
            $subquery->where('fname', 'like', "%{$search_cus}%")
                ->orWhere('lname', 'like', "%{$search_cus}%");
        });
    }

    if ($search_cus_id) {
        $query->orWhere(function ($subquery) use ($search_cus_id) {
            $subquery->where('idnumber', 'like', "%{$search_cus_id}%")
                ->orWhere('passportnumber', 'like', "%{$search_cus_id}%");
        });
    }

    if ($search_cus_number) {
        $query->where('phonenumber', 'like', "%{$search_cus_number}%");
    }

    $cus = $query->get();

    return response()->json(['data' => $cus]);
}

public function insertBooking(Request $request)
{
    $request->validate([
        'invoice' => 'required|unique:bookings,invoice_number',
        'vehicle_name' => 'required',
        'cusid' => 'required',
        'vehicle_number' => 'required',
        'customer_name' => 'required',
        'id_card' => 'required',
        'passport' => 'required',
        'mobile' => 'required|numeric',
        's_date' => 'required',
        'e_date' => 'required',
        'destination' => 'required',
        'agreemile'=> 'required',
        'deposit'=> 'required',
        'additonal_cost_km'=> 'required'
        
    ], [
        's_date.required' => 'The start date field is required.',
        'e_date.required' => 'The end date field is required.',
        'agreemile'=> 'The agree miledge field is required.',
    ]);

        // $checkInv = VehicleAvaorUna::where('vehicle_number', $request->vehicle_number)->first();
        // $stcheck=$checkInv->booking_status;
        //         if (!$checkInv) {
        //             return back()->with('f', 'Vehicle not found');
        //         }

 // Get the start and end dates from the request
$start_date = $request->s_date;
$end_date = $request->e_date;


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
                        'invoice_number' => $request->invoice,
                        'vehicle_number' => $request->vehicle_number,
                        'vehicle_name' => $request->vehicle_name,
                        'customer_id'=> $request->cusid,
                        'customer_name' => $request->customer_name,
                        'cus_id' => $request->id_card,
                        'cus_passport' => $request->passport,
                        'mobile' => $request->mobile,
                        'vehicle_pickup_location' => $request->destination,
                        'start_date' => $request->s_date,
                        'end_date' => $request->e_date,
                        'status' => $statusValue,
                        'reg_date' => $currentDate,
                        'flight_number'=>$request->flight_number,
                        'arrival_date'=>$request->arrival_date,
                        'landing_time'=>$request->landing_time,
                        'wa_number'=>$request->wa_number,
                        'additonal_cost_km'=>$request->additonal_cost_km,
                        'agreedmile'=>$request->agreemile,
                        'created_at' => $currentTimestamp,
                        'updated_at' => $currentTimestamp
                    ];

                    if (!empty($request->advanced)) {
                        $data['advanced'] = $request->advanced;
                    }

                    if (!empty($request->amount)) {
                        $data['amount'] = $request->amount;
                    }

                    if (!empty($request->topay)) {
                        $data['rest'] = $request->topay;
                    }





                    $condition = ['vehicle_number' => $request->vehicle_number];
                    $updateAva = [
                        'book_date' => $request->s_date,
                        'release_date' => $request->e_date,
                        'booking_status' => $statusValue
                    ];
                    $cus_input_id = $request->input('cusid');
                        $deposit_input = $request->input('deposit');

                        // Check if the customer exists
                        $customer = CustomerDeposit::where('cus_id', $cus_input_id)->first();

                        if ($customer) {
                            // Customer exists, update the deposit
                            $customer->deposit += $deposit_input;
                            $customer->current_deposit +=$deposit_input;
                            $customer->save();
                        } else {
                            // Customer does not exist, insert a new record
                            $sendDeposit = [
                                'cus_id' => $cus_input_id,
                                'invoice' => $request->invoice,
                                'name' => $request->customer_name,
                                'id_number' => $request->id_card,
                                'passport' => $request->passport,
                                'deposit' => $deposit_input,
                                'current_deposit' => $deposit_input
                            ];

                            CustomerDeposit::insert($sendDeposit);
                        }
                    
                    DB::transaction(function () use ($data, $condition, $updateAva) {
                        Booking::insert($data);
                        //VehicleAvaorUna::where($condition)->update($updateAva);
                        
                    });
                    

                    $num=Vehicle::where('vehicle_number',$request->vehicle_number)->pluck('id')->first();

                    $data=[
                         'vid'=>$num ,
                         'startdate'=>$request->s_date , 
                         'enddate'=>$request->e_date
                    ];

                    BookVehicle::create($data);
                    // event(new BookingUpdated($data));

                    return back()->with('s', 'Data added successfully');
                } catch (\Throwable $th) {
                    // Log or handle the exception appropriately
                    dd($th);
                    return back()->with('f', 'Error, Data could not be added');
                }
                      

                



    
}



//filer booking data in employee assign
public function filterBooking(Request $request)
{
    $search2 = $request->input('search_book_input');
    $search_all = $request->input('search_all');
    $sb = $request->input('sbinput');

    $query = Booking::whereIn('status', ['On going', 'booked']);
 // Add condition for status equal to 'booked'

    if ($search_all) {
        $query->where(function ($subquery) use ($search_all) {
            $subquery->where('invoice_number', 'like', "%{$search_all}%")
                ->orWhere('vehicle_number', 'like', "%{$search_all}%");
        });
    }

    if ($search2) {
        $query->where(function ($subquery) use ($search2) {
            $subquery->where('invoice_number', 'like', "%{$search2}%")
                ->orWhere('vehicle_number', 'like', "%{$search2}%");
        });
    }

    if ($sb) {
        $query->where(function ($subquery) use ($sb) {
            $subquery->where('invoice_number', 'like', "%{$sb}%")
                ->orWhere('vehicle_number', 'like', "%{$sb}%");
        });
    }

    $booking = $query->latest()->get(); // Paginate the results with 5 items per page

    return response()->json(['data' => $booking]);
}


//get employeeee to dropdown
public function getEmployeeNames()
{
    $employees = Attendence::where('status', 'IN')->get(['user_id', 'name']);

    return response()->json(['data' => $employees]);
}

//assign employeee
public function assignEmployee(Request $request)
{
    try {
        $request->validate([
            'inv' => 'required',
            'empdropdown' => 'required',
            'checkboxes' => 'required|array',
            'taskDesc2' => 'nullable|string', // Allow taskDesc to be nullable
        ], [
            'checkboxes' => 'Please check any of the checkboxes',
        ]);

        // Retrieve user by ID
        $user = User::findOrFail($request->empdropdown);

        $condition = ['invoice_number' => $request->inv];

        // Retrieve the existing select_employee value
        $existingEmployee = Booking::where($condition)->value('select_employee');

        // If there's an existing employee, append the new employee with a comma
        $newEmployee = $user->fname . ' ' . $user->lname;
        $newSelectEmployee = $existingEmployee ? $existingEmployee . ', ' . $newEmployee : $newEmployee;

        // Prepare data for booking update
        $data = ['select_employee' => $newSelectEmployee];

        $currentDate = now()->toDateString();
        $taskStatus = "uncomplete";

        // Get the checked checkbox values and associated task descriptions
        $checkedValues = $request->input('checkboxes', []);
        $taskDescriptions = $request->input('taskDesc2', []);

        // Create an array to store task data
        $tasksData = [];

        // Iterate through checked checkbox values and associated task descriptions
        foreach ($checkedValues as $index => $checkedValue) {
            // If task description is not provided, set it to a default value (e.g., empty string)
            $taskDescription = $taskDescriptions[$index] ?? '';

            // Create task data for each checked value and associated task description
            $tasksData[] = [
                'user_id' => $user->id,
                'name' => $user->fname . ' ' . $user->lname,
                'date' => $currentDate,
                'task_desc' => $taskDescription,
                'status' => $taskStatus,
                'task_type' => $checkedValue,
                'inv' => $request->inv
            ];
        }

        // Create tasks in bulk
        Task::insert($tasksData);

        // Update booking data
        Booking::where($condition)->update($data);

        return back()->with('s', 'Assigned the employee successfully');
        
    } catch (Exception $e) {
        return back()->with('f', 'Could not add the employee');
    }
}








public function assignEmployeebook(Request $request)
{
    try {
        $request->validate([
            'invw' => 'required',
            'empdrop' => 'required',
            'checkb' => 'required|array', // Ensure checkb is an array
            'taskDesc' => 'nullable|array', // Allow taskDesc to be nullable
        ], [
            'checkb' => 'Please check any of the checkboxes',
        ]);

        $user = User::find($request->empdrop);

        if (!$user) {
            
            return back()->with('f', 'User not found');
        }

        $currentDate = now()->toDateString();
        $taskStatus = "uncomplete";

        // Get the checked checkbox values and their descriptions
        $checkedValues = $request->input('checkb', []);
        $taskDescriptions = $request->input('taskDesc', []);

        // Prepare an array to store task data
        $tasksData = [];

        // Iterate through checked checkbox values
        foreach ($checkedValues as $index => $checkedValue) {
            // Get the task description corresponding to the checkbox
            $taskDescription = $taskDescriptions[$index] ?? '';

            // Create task data for each checked checkbox
            $tasksData[] = [
                'user_id' => $user->id,
                'name' => $user->fname . ' ' . $user->lname,
                'date' => $currentDate,
                'task_desc' => $taskDescription,
                'status' => $taskStatus,
                'task_type' => $checkedValue,
                'inv' => $request->invw,
                'vehicle_number'=>$request->vn
            ];
        }

        // Create tasks in bulk
        Task::insert($tasksData);

        // Update booking data
        $condition = ['invoice_number' => $request->invw];
        $existingEmployee = Booking::where($condition)->value('select_employee');
        $newEmployee = $user->fname . ' ' . $user->lname;
        $newSelectEmployee = $existingEmployee ? $existingEmployee . ', ' . $newEmployee : $newEmployee;

        // Update booking data in a single query
        Booking::where($condition)->update(['select_employee' => $newSelectEmployee]);



// $url = 'https://fcm.googleapis.com/fcm/send';
//  //$userId = "18";
//         $FcmToken = User::where('id', $request->empdrop)->pluck('device_token')->first();

            
//         $serverKey = 'AAAA-nQzO2A:APA91bGZi5ssCZGCdthRcpeSx2EPXIHgxJu1QBGj9H_4440VQehd1r_bhaXL-w0rrEWGF8azC7q1FlvXAbf4Ax6Jj42fj1vOqDjujaIVbhjHMdokoedgw_ClEU0TNns-t44FzWSQP32B'; // ADD SERVER KEY HERE PROVIDED BY FCM
//     $body="ready vehicle";
//     $tit="hello";
        
// $data = [
//     "registration_ids" => [$FcmToken], // Wrap $FcmToken in an array
//     "notification" => [
//         "title" => $tit,
//         "body" => $body,  
//     ]
// ];

//         $encodedData = json_encode($data);
    
//         $headers = [
//             'Authorization:key=' . $serverKey,
//             'Content-Type: application/json',
//         ];
    
//         $ch = curl_init();
        
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//         // Disabling SSL Certificate support temporarly
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
//         // Execute post
//         $result = curl_exec($ch);
//         if ($result === FALSE) {
//             die('Curl failed: ' . curl_error($ch));
//         }        
//         // Close connection
//         curl_close($ch);
        // FCM response
        //dd($result);
        return back()->with('s', 'Assigned the employee successfully');
    } catch (Exception $e) {
        return back()->with('f', 'Could not add the employee');
    }
}



public function invoice(Request $request){


$invoice=Booking::latest()->paginate(10);
return view('inf.invoice',compact('invoice'));
}
public function filterInvoices(Request $request)
{
    $invoiceNumber = $request->input('invoice_number');
    $customerName = $request->input('customer_name');

     $query = Booking::query();

    if ($invoiceNumber) {
        $query->where('invoice_number', 'like', '%' . $invoiceNumber . '%');
    }

    if ($customerName) {
        $query->where('customer_name', 'like', '%' . $customerName . '%');
    }

    $filteredInvoices = $query->get();

    return response()->json($filteredInvoices);
}

public function invoiceDetails($invoiceid, Request $request)
{
    $currentDate = now()->toDateString();
    $bankName = $request->input('bankName');
    $accountNumber = $request->input('accountNumber');
    $invoices = Booking::where('invoice_number', $invoiceid)->get();
    
    $status="completed";



    if (!$invoices->isEmpty()) {
        $depo=CustomerDeposit::where('cus_id',$invoices[0]->customer_id)->pluck('current_deposit')->first();
        return view('inf.bill',compact('invoices','status','currentDate','depo','bankName','accountNumber'));
    } else {
        dd("No data found for invoice ID: $invoiceid");
    }
}





public function genarateInvoice($invoiceid, Request $request) {
    
    $bankName = $request->input('bankName');
    $accountNumber = $request->input('accountNumber');
    $currentDate = now()->toDateString();
    $invoices = Booking::where('invoice_number', $invoiceid)->get();

    if (!$invoices->isEmpty()) {
        $depo = CustomerDeposit::where('cus_id', $invoices[0]->customer_id)->pluck('current_deposit')->first();
        $data = [
            'invoices' => $invoices,
             'bankName' => $bankName,
            'accountNumber' => $accountNumber,
            'currentDate' => $currentDate,
            'depo' => $depo
        ];

        // Generate the PDF view without downloading
        $pdf = Pdf::loadView('inf.bill', $data);
        return $pdf->stream('invoice'.$invoiceid.'.pdf');
    } else {
        dd("No data found for invoice ID: $invoiceid");
    }
}





public function loadBrandInFrom(Request $request){

    $cat=$request->input('cat');
    $models = Vehiclebrand::where('addnewcat', $cat)->get();

    return response()->json($models);

}



// delete booking
public function deleteBooking($id, Request $request) {
    try {
        // Find the booking record by ID
        $booking = Booking::findOrFail($id);
        $vnumber = $booking->vehicle_number;

        // Find the vehicle ID by vehicle number
        $vid = Vehicle::where('vehicle_number', $vnumber)->pluck('id')->first();

        // Find the BookVehicle record by vehicle ID
        $bookVehicle = BookVehicle::where('vid', $vid)->first();

        // Delete the BookVehicle record if it exists
        if ($bookVehicle) {
            $bookVehicle->delete();
        }

        // Delete the booking record
        $booking->delete();

        return back()->with('s', 'Booking deleted successfully.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle model not found exception
        return back()->with('f', 'Booking not found.');
    } catch (Exception $e) {
        // Handle any other exceptions
        return back()->with('f', 'Could not delete booking. ' . $e->getMessage());
    }
}



public function getVehiclePopStatus(Request $request)
{
$vnumber=$request->input('number');
    $vehicle = DashBoardvehicle::where('vnumber', $vnumber)->first();
    $status = $vehicle->current_status;
     return response()->json($status);
    
}

}
