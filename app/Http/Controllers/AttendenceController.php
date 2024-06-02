<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\User;
use Carbon\Carbon;

class AttendenceController extends Controller
{
    public function index(){

        $user =User::all();
        
        return view('inf.attendence',['users'=>$user]);
        
    }
    //load data
    public function loadData($name){
        $user = User::where('fname', $name)->get();
    
        return response()->json($user);
    }
    // user attendence IN
    public function attendenceIn(Request $request){

    $request->validate([
        'name' => 'required',
        'in_date' => 'required',
    ]);

    // Get the user by name
    $user = User::where('username', $request->name)->first();

    // Check if the user exists
    if (!$user) {
        return back()->with('f1', 'Error, User not found');
    }

// Check if it's before 8:00 AM
$eightAM = Carbon::createFromTime(8, 0, 0); // 8:00 AM
$currentDateTime = Carbon::now();
if ($currentDateTime->lt($eightAM)) {
    return back()->with('f1', 'Error, You can only make IN entry after 8:00 AM');
}

// Check if it's after 5:30 PM
$fiveThirtyPM = Carbon::createFromTime(17, 30, 0); // 5:30 PM
if ($currentDateTime->gt($fiveThirtyPM)) {
    return back()->with('f1', 'Error, You can only make IN entry before 5:30 PM');
}


    // Check if there's an existing OUT record for the previous day
    $previousDay = Carbon::parse($request->in_date)->subDay();
    $existingRecordOut = Attendence::where([
        'user_id' => $user->id,
        'out_date' => $previousDay->toDateString(),
        'status' => 'OUT'
    ])->first();

    // if (!$existingRecordOut) {
    //     // No OUT record found for the previous day, prevent IN entry
    //     return back()->with('f1', 'Error, You must make an OUT entry for the previous day before making an IN entry');
    // }

    $condition = [
        'user_id' => $user->id,
        'status' => 'IN', 
        'in_date' => $request->in_date,
    ];

    $existingRecord = Attendence::where($condition)->first();
    if ($existingRecord) {
        return back()->with('f1', 'Error, You have already made IN for the day');
    }

    $dateTime = Carbon::now();
    $timeOnly = $dateTime->format('H:i');

    $data = [
        'user_id' => $user->id, // Add user_id to the data array
        'in_date' => $request->in_date,
        'name' => $user->fname . ' ' . $user->lname, 
        'in_time' => $timeOnly,
        'status' => 'IN',
    ];

    Attendence::create($data);

    return back()->with('s1', 'Data added successfully');
}

    //user attendence OUT
   public function attendenceOut(Request $request)
{
    $request->validate([
        'name2' => 'required',
        'out_date' => 'required',
        'desc' => 'required'
    ], [
        'name2' => 'The name field is required'
    ]);
    
    // Get the user by name
    $user = User::where('username', $request->name2)->first();

    // Check if the user exists
    if (!$user) {
        return back()->with('f1', 'Error, User not found');
    }

    // Check if it's before 8:00 AM for OUT entry
    $eightAM = Carbon::createFromTime(8, 0, 0); // 8:00 AM
    $currentDateTime = Carbon::now();
    if ($currentDateTime->lt($eightAM)) {
        return back()->with('f1', 'Error, You can only make OUT entry after 8:00 AM');
    }

    // Check if there's an existing "OUT" record for the same user and date
    $existingRecordOut = Attendence::where([
        'user_id' => $user->id,
        'out_date' => $request->out_date,
        'status' => 'OUT'
    ])->first();

    if ($existingRecordOut) {
        // Record with OUT status exists, user can't make another OUT request
        return back()->with('f', 'Error, You have already made an OUT entry for the day');
    }

    // Check if there's an existing "IN" record for the same user and date
    $existingRecordIn = Attendence::where([
        'user_id' => $user->id,
        'in_date' => $request->out_date, 
        'status' => 'IN'
    ])->first();

    if ($existingRecordIn) {
        // Record exists, proceed with the calculations
        $inTime = Carbon::createFromFormat('H:i', $existingRecordIn->in_time);

        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Check if it's after 5:30 PM
        $fiveThirtyPM = Carbon::createFromTime(17, 30, 0); // 5:30 PM
        if ($currentDateTime->gt($fiveThirtyPM)) {
            // Calculate the total minutes worked
            $totalMinutesWorked = $inTime->diffInMinutes($currentDateTime);

            // Calculate the regular working hours in minutes (8:00 AM to 5:30 PM)
            $regularWorkingHoursInMinutes = 9 * 60 + 30; // 9 hours and 30 minutes

            // Calculate the overtime in minutes
            $overtimeInMinutes = max(0, $totalMinutesWorked - $regularWorkingHoursInMinutes); // Overtime can't be negative
        } else {
            // If it's before 5:30 PM, set overtime to 0
            $overtimeInMinutes = 0;
        }

        // Prepare the data to update
        $data = [
            'out_date' => $request->out_date,
            'out_time' => $currentDateTime->format('H:i'),
            'status' => 'OUT',
            'desc' => $request->desc,
            'ot' => $overtimeInMinutes // Set the calculated overtime in minutes
        ];

        // Update the OUT record
        $condition = [
            'user_id' => $user->id,
            'in_date' => $request->out_date
        ];
        Attendence::where($condition)->update($data);

        return back()->with('s', 'Data added successfully');
    } else {
        // Record does not exist, handle accordingly (e.g., display an error message)
        return back()->with('f', 'Error, No corresponding IN entry found for the day');
    }
}




}
