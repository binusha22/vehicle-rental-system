<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Task;

class TripDetailsController extends Controller
{
    public function index(Request $request){

       // Get latest bookings with status "booked" (sorted by created_at in descending order)
$bookings = Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();

// Get latest bookings with status "pending" (sorted by created_at in descending order)
$bookingsPending = Booking::latest()->get();

$booksecond = $bookingsPending;

$booksthreed = Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();

return view('inf.car_trip', [
    'bookings' => $bookings,
    'booksecond' => $booksecond,
    'booksthreed' => $booksthreed
]);

    }
   
public function search(Request $request)
{
    $invoiceNumber = $request->input('invoiceNumber');
    $vehicleNumber = $request->input('vehicleNumber');
    $searchDate = $request->input('searchDate');

    $query = Booking::query();

    if ($invoiceNumber) {
        $query->where('invoice_number', $invoiceNumber);
    }

    if ($vehicleNumber) {
        $query->where('vehicle_number', $vehicleNumber);
    }

    if ($searchDate) {
        // Assuming the 'searchDate' is a valid date format, you can adjust accordingly
        $query->whereDate('reg_date', '=', $searchDate);
    }

    // Check if any search parameter is provided
    if ($invoiceNumber || $vehicleNumber || $searchDate) {
        // Execute the query to retrieve filtered bookings
        $bookings = $query->paginate(10)->withQueryString();
    } else {
        // If no search parameter is provided, return an empty result set
        $bookings = Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();
    }

    $booksecond = Booking::latest()->get();
    $booksthreed = Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();

    return view('inf.car_trip', [
        'bookings' => $bookings,
        'booksecond' => $booksecond,
        'booksthreed' => $booksthreed
    ]);
}



//second search function
public function searchsecond(Request $request)
{
    $searchVAl = $request->input('getsearch');
   

    $query = Booking::query();

    if ($searchVAl) {
        $query->where(function ($subquery) use ($searchVAl) {
            $subquery->where('invoice_number', 'like', "%{$searchVAl}%")
                ->orWhere('vehicle_number', 'like', "%{$searchVAl}%");
        });
    }

    // Execute the query to retrieve filtered bookings
    $booksecond = $query->paginate(10)->withQueryString();
$bookings = Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();
$booksthreed= Booking::where('status', 'On going')->orderBy('created_at', 'desc')->get();
    return view('inf.car_trip',['bookings'=>$bookings,'booksecond'=>$booksecond,
            'booksthreed'=>$booksthreed]);
}


public function searchthredd(Request $request)
{
    $invoiceNumber = $request->input('invoiceNumber2');
    $vehicleNumber = $request->input('vehicleNumber2');
    $searchDate = $request->input('searchDate2');

    $query = Booking::query();

    if ($invoiceNumber) {
        $query->where('invoice_number', $invoiceNumber);
    }

    if ($vehicleNumber) {
        $query->where('vehicle_number', $vehicleNumber);
    }

    if ($searchDate) {
        // Assuming the 'searchDate' is a valid date format, you can adjust accordingly
        $query->whereDate('reg_date', '=', $searchDate);
    }

    // Execute the query to retrieve filtered bookings 
    $bookings =Booking::where('status', 'booked')->orderBy('created_at', 'desc')->get();
    $booksecond = latest()->get();
$booksthreed = $query->paginate(10)->withQueryString();

    return view('inf.car_trip',['bookings'=>$bookings,'booksecond'=>$booksecond,
            'booksthreed'=>$booksthreed]);
}

//assign task to employee
public function assignEmp(Request $request){

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
                'vehicle_number'=>$request->vn,
                'imageUrl'=>$request->selectedImageUrl
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


 return back()->with('s', 'successfully assigned the user');

    } catch (Exception $e) {
        return back()->with('f', 'Could not add the employee');
    }

    }
}
