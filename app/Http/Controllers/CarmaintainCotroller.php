<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staks;
use App\Models\Svalues;
use App\Models\Vehicleregister;
use App\Models\Attendence;
use App\Models\Vehicle_reg_mielage;
use App\Models\Servicecost;
use App\Models\Servicesecond;
use Illuminate\Support\Facades\Log;
use Pusher\PushNotifications\PushNotifications;


class CarmaintainCotroller extends Controller
{

public function index(Request $request){


    $vehicleNumbers = Vehicleregister::pluck('vehicle_number');
 $query = $request->input('search');
 $query2=$request->input('searchsecond');
 $query3=$request->input('searchthredd');
        
        // Check if there's a search query
        if ($query) {
            // Get services filtered by both search query and status 'uncomplete'
            $services = Servicecost::where('vnumber', 'like', '%' . $query . '%')
                        ->where('status', 'uncomplete')
                        ->latest()
                        ->paginate(6);
        } else {
            // Get services with status 'uncomplete' only
            $services = Servicecost::where('status', 'uncomplete')
                        ->latest()
                        ->paginate(6);
        }
        
    if ($query2) {
            $staksData = Staks::with(['svalues' => function ($query) {
                // Remove the where condition to get all values from svalues
            }])
            ->where('status', 'uncomplete') // Filter Staks based on status
            ->where('vnumber', $query2)
            ->orderBy('id', 'desc') 
            ->get();
        } else {
            $staksData = Staks::with(['svalues' => function ($query) {
                // Remove the where condition to get all values from svalues
            }])
            ->where('status', 'uncomplete') // Filter Staks based on status
            ->orderBy('id', 'desc') 
            ->get();
        }
    
        $query3 = $request->input('searchthredd');

            if ($query3) {
                $ssecond = Servicesecond::where('vnumber', $query3)->latest()->paginate(6);
            } else {
                $ssecond = Servicesecond::latest()->paginate(6);
            }


    

$employees = Attendence::where('status', 'IN')->get(['user_id', 'name']);
    return view('inf.car_maintain',compact('vehicleNumbers','employees','services','staksData','ssecond'));
}


   public function saveCheckData(Request $request)
{
    try {
        $request->validate([
            'vname' => 'required',
            'adate' => 'required',
            'emp' => 'required',
            'vnumber' => 'required'
        ]);

        // Extract data from the request
        $checkedCheckboxes = $request->input('checkboxes');
        $vehicleNumber = $request->vnumber;
        $vehiclename = $request->vname;
        $employees = $request->emp;
        $date = $request->adate;
        $st = 'uncomplete';

        // Find the user
        $user = User::find($request->emp);

        // If user not found, return with a message
        if (!$user) {
            return back()->with('f', 'User not found');
        }

        // Create a new Staks entry
        $staksData = [
            'user_id' => $user->id,
            'vname' => $vehiclename,
            'vnumber' => $vehicleNumber,
            'emp_name' => $user->fname . ' ' . $user->lname,
            'date' => $date,
            'status' => $st
        ];

        // Store the created Staks entry in a variable
        $staks = Staks::create($staksData);

        // Define the status
        $status = "uncomplete";

        // Iterate through the nested array to process the data
        foreach ($checkedCheckboxes as $tabId => $checkboxValues) {
            foreach ($checkboxValues as $checkboxValue) {
                $svaluesData = [
                    'staks_id' => $staks->id,
                    'type' => $tabId,
                    'checked_value' => $checkboxValue,
                    'status' => $status,
                ];

                // Create the Svalues entry
                Svalues::create($svaluesData);
            }
        }

        

        return back()->with('s', 'Assigned the employee successfully');
    } catch (Exception $e) {
        return back()->with('f', 'Could not add the employee');
    }
}


//set data complete in svalues table
public function setDataComplete(Request $request)
{
     $checkedIdsArray = $request->input('checkboxes');

    // Loop through each category and its IDs
    foreach ($checkedIdsArray as $category => $ids) {
        foreach ($ids as $id) {
            // Find the record by ID and update its status
            $svalue = Svalues::find($id);
            if ($svalue) {
                $svalue->status = 'complete';
                $svalue->save();
            }

        }
        
    }

    // Optionally, return a response or redirect
    return redirect()->back()->with('s', 'Selected items updated successfully.');
}



//set service sub task complete
public function setServiceComplete(Request $request){

    try {
        $checkId=$request->input('tid');
    $id=$request->input('mtid');
$request->validate([
'cost'=>'required',
'desc'=>'required'
]);

$maintask=Staks::findOrFail($id);
 $task = Svalues::findOrFail($checkId);
 //
 
    $task->update(['status' => 'complete']);
$st='uncomplete';
    $data=[
        'vnumber'=>$maintask->vnumber,
        'vname'=>$maintask->vname,
        'date'=>$maintask->date,
        'cost'=>$request->cost,
        'des'=>$request->desc,
        'status'=>$st
    ];

            Servicecost::create($data);
        return back()->with('s', 'Service Data uploaded successfully.<br>Now complete the task');
    } catch (Exception $e) {
         return back()->with('f', 'Data couldnt add to table');
            
    }
}


//set task complete
public function setTaskcomplete(Request $request){
    $checkId=$request->input('idtask');

    $task = Staks::findOrFail($checkId);
 
    $task->update(['status' => 'complete']);

 return back()->with('s', 'Task completed successfully.');
}

//get vehicle names
public function getVehicleNames(Request $request)
{
    $selectedVehicleNumber = $request->input('vnumber');
    
    // Fetch the corresponding vehicle name based on the selected vehicle number
    $vehicleData = Vehicleregister::where('vehicle_number', $selectedVehicleNumber)->first();

    // Assuming 'brand' is the column containing the vehicle name
    $vehicleName = $vehicleData->brand.' '.$vehicleData->model;

    return response()->json(['vehicleName' => $vehicleName]);
}


//get vehicle names 2
public function getVehicleNames2(Request $request)
{
    $selectedVehicleNumber = $request->input('vnumber2');
    
    // Fetch the corresponding vehicle name based on the selected vehicle number
    $vehicleData = Vehicleregister::where('vehicle_number', $selectedVehicleNumber)->first();

    // Assuming 'brand' is the column containing the vehicle name
    $vehicleName = $vehicleData->brand.' '.$vehicleData->model;

    return response()->json(['vehicleName' => $vehicleName]);
}



//get values from second task
public function getSvaluesData(Request $request)
{
    $staksId = $request->input('staks_id');
    
    // Fetch data from the svalues table based on the staks_id
    $svaluesData = Svalues::where('staks_id', $staksId)->get();
    
    // Pass the fetched data to a Blade view
    return response()->json(['svaluesData' => $svaluesData]);
}
//add cost and desc to table
public function sendServicedata(Request $request){
    try{
        $vn2 = $request->input('vn2');
$id = $request->input('id');
        // Check if vn2 is empty
        if (empty($vn2)) {
            // If vn2 is empty, get the value of vnumber2
            $vn2 = $request->input('vnumber2');
        }
        $data=[
        'vnumber'=>$vn2,
        'vname'=>$request->vname2,
        'date'=>$request->date2,
        'cost'=>$request->cost2,
        'des'=>$request->desc2,
       
        ];

if($id){
    $service = Servicecost::findOrFail($id);
        
        $service->update(['status' => 'complete']);
}
        
     
        Servicesecond::create($data);
        return back()->with('s', 'Data uploaded successfully.');
    } catch (Exception $e) {
         return back()->with('f', 'Data couldnt add to table');
            
    }

       
    }



//save token 
public function saveToken(Request $request){

    $userId = session('loginId');
    $token=$request->notifi_token;

    $currentuser=User::find($userId);
    $currentuser->update(['device_token' => $token]);
     return response()->json(['successfully subscribed']);


}

public function sendNoti(Request $request){

    $userId = session('loginId');
    $currentuser=User::find($userId);

    //send notification to allocated user
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = $currentuser->device_token;
         
        $serverKey = 'AAAA-nQzO2A:APA91bGZi5ssCZGCdthRcpeSx2EPXIHgxJu1QBGj9H_4440VQehd1r_bhaXL-w0rrEWGF8azC7q1FlvXAbf4Ax6Jj42fj1vOqDjujaIVbhjHMdokoedgw_ClEU0TNns-t44FzWSQP32B';

 $fcmTitle="hello new notification";
 $fcmBody="this is body";
        $data = [
                "registration_ids" => [$FcmToken], // Wrap the token in an array
                "notification" => [
                    "title" => $fcmTitle,
                    "body" => $fcmBody,  
                ]
            ];
        $encodedData = json_encode($data);
   
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
   
        $ch = curl_init();
     
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
      echo $result;
      //return back();
   

}


public function storeNotificationToken(Request $request)
{
    // Get authenticated user ID from session
    $userId = session('loginId');

    // Log the user ID to verify it
    Log::info('Authenticated User ID: ' . $userId);

    // Retrieve the authenticated user
    $currentuser = User::find($userId);

    // Log the retrieved user to verify it
    Log::info('Authenticated User: ' . $currentuser);

    // Store notification token for the user
    $currentuser->update(['device_token' => $request->input('token')]);

    // Log a message to indicate successful token storage
    Log::info('Notification token stored for user: ' . $userId);

    // Return a JSON response
    return response()->json(['message' => 'Notification token stored.']);
}
}
