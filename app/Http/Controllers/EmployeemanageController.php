<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendence; // Corrected model name
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Salarey;
use Carbon\Carbon;


class EmployeemanageController extends Controller
{
    public function index(){
            $data=Attendence::latest()->paginate(5); // Corrected model name
          $salary=Salarey::latest()->paginate(5);
            $st = "pending";
            $st2 = "submitted";
$leaves = LeaveRequest::where('status', $st)
    ->latest() 
    ->paginate(7);
    $leavesSubitted = LeaveRequest::latest()
    ->paginate(7);
    $users = User::select('id', 'fname','lname')->get();
        return view('inf.manage_employee',compact('data','leaves','leavesSubitted','salary',"users"));
    }

//get data to last table
public function fetch_submited_data(Request $request)
{
    $uid = $request->input('name');
    $leavesSubitted = LeaveRequest::where('user_id', $uid)->get();

    return response()->json($leavesSubitted);
}


//fetch salry of emp
public function fetch_salary_of_emp(Request $request){
        $uid = $request->input('name');
        $date = $request->input('date');
    $salary=Salarey::where('EmpnId',$uid)->where('addDate',$date)->get();
    return response()->json($salary);
}


//fetch attaendece according to user id and date $data=Attendence::latest()->paginate(3);
public function fetch_attendence_of_emp(Request $request){
        $uid = $request->input('name');
        $date = $request->input('date');
    $data=Attendence::where('user_id',$uid)->where('in_date',$date)->get();
    return response()->json($data);
}















    //open request leave page
    public function LeaveRequest(){

        $userId = session('loginId');
        $getUser=User::where('id',$userId)->first();
        $leaveRequest= LeaveRequest::where('user_id', $userId)->first();
        $grant=$leaveRequest->grantedLeaves ?? 0;
        $name=$getUser->fname.' '.$getUser->lname;
        $leave=$getUser->mleave;
        $leavesSubitted = LeaveRequest::where('user_id',$userId)->get();
        return view('inf.leave_management',compact('name','userId','leave','grant','leavesSubitted'));
    }
    //send leave request data
    public function LeaveRequestInsert(Request $request){
        $request->validate([
                    'name'=>'required',
                    'start_date'=>'required',
                    'end_date'=>'required',
                    'reason'=>'required'

                 ]);
try{
        $st="pending";
        $currentYearMonthDay = Carbon::now()->format('Y-m-d');

        $getUser=User::where('id',$request->input('uid'))->first();
        $monthlyLeaves=$getUser->mleave;

        $user = LeaveRequest::where('user_id', $request->input('uid'))->first();
        if ($user) {
             $start_date = new \DateTime($request->start_date);
            $end_date = new \DateTime($request->end_date);

            // Calculate the difference in days
            $interval = $start_date->diff($end_date);
            $number_of_days = $interval->days;

            // Increment by one to include both start and end dates
            $number_of_days++;

            
            $user->fromDate = $request->start_date;
            $user->toDate = $request->end_date;
            
            $user->reason = $request->reason;
            $user->status = $st;
            $user->req_date = $currentYearMonthDay;
            $user->req_leaves=$number_of_days;  

            $user->save(); // Save the changes
        }else{
            
       // Assuming $request->start_date and $request->end_date are valid date strings
            $start_date = new \DateTime($request->start_date);
            $end_date = new \DateTime($request->end_date);

            // Calculate the difference in days
            $interval = $start_date->diff($end_date);
            $number_of_days = $interval->days;

            // Increment by one to include both start and end dates
            $number_of_days++;



        $data =new LeaveRequest();

        $data->user_id=$request->input('uid');
        $data->name=$request->name;
        $data->fromDate=$request->start_date;   
        $data->toDate=$request->end_date; 
        $data->leaves=$monthlyLeaves; 

        $data->grantedLeaves="0";  
        $data->restLeaves="0";

        $data->reason=$request->reason;
        $data->status=$st;
        $data->req_leaves=$number_of_days;  
        $data->req_date=$currentYearMonthDay;

        $data->save();
        }
        
                return back()->with('s', 'Data added successfully');
                } catch (\Throwable $th) {
                    // Log or handle the exception appropriately
                    
                    return back()->with('f', 'Error, Data could not be added');
                }



    }
    //update overtime 
    public function updateOT(Request $request){
         $request->validate([
            'getEmpname'=>'required',
            'addDate'=>'required',
            'newOT'=>'required',

         ]);


         $data=[
            'ot'=>$request->newOT
         ];

         $condition=[
            'id'=>$request->input('getEmpId'),
            'in_date'=>$request->addDate
         ];
 try {
         Attendence::where($condition)->update($data); // Corrected model name
            return back()->with('s', 'Data updated successfully');
                } catch (\Throwable $th) {
                    // Log or handle the exception appropriately
                    
                    return back()->with('f', 'Error, Data could not be added');
                }

    }



    //get total ot of user 

    public function getAttendance(Request $request)
{
    // Get data from request
    $employeeName = $request->input('employee_name');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Fetch attendance data for the selected employee within the specified date range
    $attendanceData = Attendence::where('user_id', $employeeName)
                                ->whereBetween('in_date', [$startDate, $endDate])
                                ->get();

    // Calculate total "ot"
    $totalOt = $attendanceData->sum('ot');

    // Get user leave data
    $userLeave = User::where('id', $employeeName)->first();
    $grantedLeaves = 0;
    $restof = 0;

    // Check if user leave data is available
    $users = LeaveRequest::where('user_id', $employeeName)->get();
    if (!$users->isEmpty()) {
        $grantedLeaves = $users->first()->grantedLeaves ?? 0;
        $restof = $users->first()->restLeaves ?? 0;
    }

    // Return the response with default values if any variable is null
    return response()->json([
        'monthlyOt' => $totalOt ?? 0,
        'employeeName' => ($userLeave->fname ?? '') . ' ' . ($userLeave->lname ?? ''),
        'leave' => $userLeave->mleave ?? 0,
        'grantedLeaves' => $grantedLeaves,
        'restof' => $restof,
        'uid'=>$employeeName
    ]);
}



//submit leaves 
public function submitLeave(Request $request)
    {
        // Validate form data
        $request->validate([
            'req_empname' => 'required',
            'req_s_date' => 'required|date',
            'req_e_date' => 'required|date',
            'req_leaves' => 'required|integer',
            'req_reason' => 'required|string',
        ]);

        $condi=[
            'id'=>$request->input('luid')
        ];
        $st="submitted";
        $ids=$request->input('luid');
        $user=LeaveRequest::where('id',$ids)->first();
        $overollLeaves=$user->leaves;

        $updateGranted=($user->grantedLeaves + $request->input('req_leaves'));
        
        $updateRestLeaves =$overollLeaves-$updateGranted;

        
        $data=[
            'grantedLeaves'=>$updateGranted,
            'restLeaves'=>$updateRestLeaves,
            'status' => $st

        ];
        LeaveRequest::where($condi)->update($data);
        return back()->with('s','update successfully');
    }




//deny 
    public function denyLeave(Request $request)
    {
$condi=[
            'id'=>$request->input('luid')
        ];

$st="denied";

        $data=[
            
            'status' => $st

        ];
        LeaveRequest::where($condi)->update($data);
        return back()->with('s','update successfully');
    }


    //insert salary
    public function inset_salary(Request $request){  

    try{ 
        $request->validate([
            'Empname' => 'required',
            'mSalary' => 'required',
            'salDate' => 'required|date'
           
        ]);


        $data = new Salarey();
        $data->salary=$request->mSalary;
        $data->addDate=$request->salDate;
        $data->name=$request->Empname;
        $data->EmpnId=$request->EmpnId;
        $data->ot_hours=$request->monthlyOt;
        $data->grant_leaves=$request->gotLeaves;

            $data->save();
        return back()->with('s','Data added successfully');
 } catch (\Throwable $th) {
                    // Log or handle the exception appropriately
                    
                    return back()->with('f', 'Error, Data could not be added');
                }

    }


//display overtime in employee section
    public function fetch_overtime(){

        $userId = session('loginId');
        return view('inf.overtime',compact('userId'));    

    }


}
