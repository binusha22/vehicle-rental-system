<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Test;
use App\Models\liecence_renew;
use App\Events\vehicle_li_insu_notifications;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Events\UserLoggedIn;
use Carbon\Carbon;
use App\Models\Logindata;
use App\Models\VehicleRegister;
use App\Models\CustomerReg;
use App\Models\Booking;
use App\Models\DashBoardvehicle;
use Illuminate\Http\Request;
use Hash;
use Session;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
}

    public function msg(){
        return view('inf.msg');
    }
    //send token
public function updateDeviceToken(Request $request)
{
    // Get the user ID from the session
    $userId = "18";

    // Find the user by ID
    $user = User::find($userId);

    if ($user) {
        // Update the device token
        $user->device_token = $request->token;
        $user->save();

        return response()->json(['Token successfully stored.']);
    } else {
        return response()->json(['User not found.'], 404);
    }
}

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
 $userId = "18";
        $FcmToken = User::where('id', $userId)->pluck('device_token')->first();

            
        $serverKey = 'AAAA-nQzO2A:APA91bGZi5ssCZGCdthRcpeSx2EPXIHgxJu1QBGj9H_4440VQehd1r_bhaXL-w0rrEWGF8azC7q1FlvXAbf4Ax6Jj42fj1vOqDjujaIVbhjHMdokoedgw_ClEU0TNns-t44FzWSQP32B'; // ADD SERVER KEY HERE PROVIDED BY FCM
    
        
$data = [
    "registration_ids" => [$FcmToken], // Wrap $FcmToken in an array
    "notification" => [
        "title" => $request->title,
        "body" => $request->body,  
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
        // FCM response
        dd($result);
    }


    //show login form
    public function showLoginForm(){

        return view('auth.login');
    }
    //show register form
    public function showRegForm(){

        $data =User::Latest()->get();
       
        return view('inf.userReg',['data'=> $data]);
        
    }
    //register user
    public function reg_user(Request $request){

        $checkUser=$request->validate([

            'fname'=>'required',
            'lname'=>'required',
            'email'=>'unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required',
            'leave'=>'required|numeric'
        ],[
            'fname'=>'first name is required',
            'lname'=>'last name is required',
        ]);

        $user =new User();
        $user->fname =$request->fname;
        $user->lname =$request->lname;
        $user->email =$request->email;
        $user->username =$request->username;
        $user->password =Hash::make($request->password);
        $user->type=$request->type;
        $user->mleave=$request->leave;
        $res = $user->save();

        if($res){
            
            return back()->with('s','User is registerd');
           
        }else{
            return back()->with('f','User is not registerd');
        }
    }
    //end register user
     //login user
     public function login_user(Request $request){

        $checkUser = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        $user = User::where('username', '=', $request->username)->first();
    
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // Store user details in the session
                $request->session()->put('loginId', $user->id);
                $request->session()->put('fname', $user->fname);
                $request->session()->put('type', $user->type);
    
                // Log login info into the logininfo table
                $loginInfo = new Logindata();
                $loginInfo->user_id = $user->id;
                $loginInfo->fname = $user->fname;
                $loginInfo->lname = $user->lname;
                $loginInfo->email = $user->email;
                $loginInfo->username = $user->username;
                $loginInfo->type = $user->type;
                $loginInfo->logintime = now(); // Assuming logintime is a timestamp
                $loginInfo->loginstatus="logged_in";

                $user->update(['status' => 1]);
                $loginInfo->save();
    


$role = $user->type;
return $this->redirectUsers($role);


            } else {
                
                return back()->with('f', 'Password not matched');
            }
        } else {
            return back()->with('f', 'This username is not registered');
            
        }
    }
    
    
    // rerirect users to their specipic dash boards
    private function redirectUsers($role){
        
            switch ($role) {
                case 'admin':
                    
                    return redirect()->route('admin.dashboard')->with('s','welcome');
                    
                case 'employee':
                    // return redirect()->route('emp-dashboard');
                return redirect()->route('show_task');
                case 'manegment':
                    // Add your employee route here if needed
                    return redirect()->route('manegment-dashboard');
                default:
                    return redirect()->back();
            }
        
       
        
    }
    public function admin_dash(){
        $currentMonth = Carbon::now()->month;
$currentYear = Carbon::now()->year;

$countOfRecords = Booking::whereMonth('reg_date', $currentMonth)
                          ->whereYear('reg_date', $currentYear)
                          ->count();


        $countOfCustomers = CustomerReg::whereNotNull('id')->count();
        $countOfUser = User::whereNotNull('id')->count();
        

        $countOfVehicIN = DashBoardvehicle::where('current_status', 'Yard in')->count();
        $countOfVehicOUT = DashBoardvehicle::where('current_status', 'Trip_out')->count();

        return view('inf.adminDash',
            compact('countOfCustomers','countOfUser','countOfVehicIN','countOfVehicOUT','countOfRecords'));
    }
    public function user_dash(){
        
        return view('inf.userDash');
    } 
    // user log out
    public function userLogout(){

        if(Session::has('loginId')){
            

            $user = User::where('id', '=', Session::get('loginId'))->first();
             // Log login out info into the logininfo table
             $loginInfo = new Logindata();
             $loginInfo->user_id = $user->id;
             $loginInfo->fname = $user->fname;
             $loginInfo->lname = $user->lname;
             $loginInfo->email = $user->email;
             $loginInfo->username = $user->username;
             $loginInfo->type = $user->type;
             $loginInfo->logintime = now();
             $loginInfo->loginstatus="logged_out";

             $user->update(['status' => 0]);
             $loginInfo->save();
             

             Session::pull('loginId');
            Session::pull('fname');
            Session::pull('type');
            session()->forget('notifications');

            

            return redirect('/login');
        }
    }
    public function displyHome(){
        $data= array();
        if(Session::has('loginId')){
            $data =User::where('id','=',Session::get('loginId'))->first();
        }
        return view('inf.home',compact('data'));
    }
   //management dash
   public function emp_dash(){

    $currentMonth = Carbon::now()->month;
$currentYear = Carbon::now()->year;

$countOfRecords = Booking::whereMonth('reg_date', $currentMonth)
                          ->whereYear('reg_date', $currentYear)
                          ->count();


        $countOfCustomers = CustomerReg::whereNotNull('id')->count();
        $countOfUser = User::whereNotNull('id')->count();
        $countOfVehic = VehicleRegister::whereNotNull('id')->count();

        $countOfVehicIN = DashBoardvehicle::where('current_status', 'Yard in')->count();
        $countOfVehicOUT = DashBoardvehicle::where('current_status', 'Trip_out')->count();

        return view('inf.emp',
            compact('countOfCustomers','countOfUser','countOfVehic','countOfVehicIN','countOfVehicOUT','countOfRecords'));
    
   }
   //user update 
   public function userUpdate($id,Request $request){

$checkdata=$request->validate([
'fname2'=>'required',
'lname2'=>'required',
'username2'=>$request->input('check2') == 'new' ? 'required|unique:users,username' : 'required',
'email2' => $request->input('check') == 'new' ? 'required|email|unique:users,email' : 'required',
'password2'=>'required',
'type2'=>'required',
'leave2'=>'required|numeric',


]);
$data=[
            'fname'=>$request->fname2,
            'lname'=>$request->lname2,
            'email'=>$request->email2,
            'username'=>$request->username2,
            'password'=>Hash::make($request->password2),
            'type'=>$request->type2,
            'mleave'=>$request->leave2,
];

$condition=[
    'id'=>$id
];
User::where($condition)->update($data);
        return back()->with('s','Updated the user');
   }

   //user delete 
   public function userDlete($id){

try {
    $user = User::findOrFail($id);
    $user->delete();
    return back()->with('s', 'User deleted successfully.');
    
} catch (Exception $e) {
     return back()->with('f', 'Could not delete user.');
}
    
   }

   public function loggedUsers(Request $request)
    {
        // Set response headers for SSE
        $response = new StreamedResponse(function () {
            while (true) {
                // Fetch logged-in users from the database
                $loggedInUsers = User::where('status', 1)->get();

                // Format user data as JSON
                $data = json_encode($loggedInUsers);

                // Send SSE event
                echo "data: $data\n\n";

                // Flush the output buffer
                ob_flush();
                flush();

                // Delay between updates (e.g., 5 seconds)
                sleep(5);
            }
        });

        // Set headers for SSE
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
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
