<?php

namespace App\Http\Controllers;
use App\Models\Vehiclebrand;
use App\Models\Vehiclemodel;
use App\Models\Vehicleregister;
use App\Models\Vehiclecategory;
use App\Models\liecence_renew;
use App\Models\InsuRenew;
use App\Models\VehicleAvaorUna;
use App\Models\Vehicle_status;
use App\Models\Vehicle_reg_mielage;
use App\Models\OwnerPayment;
use Carbon\Carbon;
use App\Models\CustomerReg;
use App\Models\Vehicle;
use App\Models\Vcategory;
use App\Services\VehicleService;
use App\Models\DashBoardvehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormController extends Controller
{

    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }
    //show vehicle register page
    public function car_registration()
    {
        $data= Vehicleregister::latest()->get();
        $branddata= Vehiclebrand::all();
        $vdata= Vcategory::all();
        return view('inf.car_registration',['data'=>$data ,'branddata'=>$branddata,'vdata'=>$vdata]);
    }
    //insert brand
    public function insertBrand(Request $request){
            
        $brand=$request->validate([

            'brand'=>'required',
            'addnewcat'=>'required'
            
        ]);
        $data =new Vehiclebrand();
        $data->brand =$request->brand;
        $data->addnewcat=$request->addnewcat;
        $res= $data->save();

        if($res){
            return back()->with('s','brand added');
        }else{
            return back()->with('f','couldnt add this');
        }
    }
//insert category
    public function insertCat(Request $request){
            
        $brand=$request->validate([

            'vcat'=>'required'
            
        ]);
        $data =new Vcategory();
        $data->vcat =$request->vcat;
        $res= $data->save();

        if($res){
            return back()->with('s','category added');
        }else{
            return back()->with('f','couldnt add the category');
        }
    }
    //load brands
    public function loadBrand(){
        $data= Vehiclebrand::all();

        return response()->json($data);
    }
    //load category
    public function loadCat(){
        $data= Vehiclebrand::all();

        return response()->json($data);
    }


    //insert data to model
    public function insertModel(Request $request)
{
    $modelData = $request->validate([
        'modelget' => 'required',
        'brand2' => 'required',
        'vcat2'=> 'required'
    ],[
        'modelget' => 'model field is required',
        'vcat2'=> 'vehicle category field is required',
        'brand2'=>'vehicle brand field is required'
    ]);

    // Insert data into Vehiclemodel table
    $vehicleModel = new Vehiclemodel();
    $vehicleModel->model = $modelData['modelget'];
    $modelInserted = $vehicleModel->save();

    // Insert data into Vehiclecategory table only if data was successfully inserted into Vehiclemodel
    if ($modelInserted) {
        $vehicleCategory = new Vehiclecategory();
        $vehicleCategory->brand2 = $modelData['brand2'];
        $vehicleCategory->model = $modelData['modelget'];
        $vehicleCategory->vcat = $modelData['vcat2'];
        $categoryInserted = $vehicleCategory->save();

        if ($categoryInserted) {
            return back()->with('s', 'data added successfully');
        } else {
            // Rollback the Vehiclemodel insertion if Vehiclecategory insertion fails
            $vehicleModel->delete();
            return back()->with('f', 'Could not add data to Vehiclecategory');
        }
    } else {
        return back()->with('f', 'Could not add data to Vehiclemodel');
    }
}
//load models
public function loadModel($brandId, $catId) {
    $models = Vehiclecategory::where('brand2', $brandId)->where('vcat', $catId)->get();
    return response()->json($models);
}


//load brand in form
public function loadBrandInFrom($brandId){
    $models = Vehiclebrand::where('addnewcat', $brandId)->get();

    return response()->json($models);

}
//add data to vehicle register page
public function vehicleRegister(Request $request){
   // Validate the incoming request data
   $request->validate([
    
    'year' => 'required',
    'vehicle_number' => 'required|unique:vehicleregisters,vehicle_number',
    'mielage' => 'required',
    'lice_start' => 'required',
        'lice_end' => 'required',
        'insu_start' => 'required',
        'insu_end' => 'required',
        'registerdate' => 'required',
        'chasis'=> 'required',
        'engine_number'=> 'required',
        'vehicle_color'=> 'required',
        'model'=>'required',
        'addVcat'=>'required'
       
    // Add more validation rules as needed
    // ...

    // Additional validation rules if "Other Owner" is selected
    // 'owner_fname' => 'required_if:owner_type,other Owner',
    // 'owner_id' => 'required_if:owner_type,other Owner',
    // 'owner_phone_number' => 'required_if:owner_type,other Owner',
    
],[
'addVcat'=> 'vehicle category is required'
]);

   $res=Vehicleregister::where('vehicle_number',$request->vehicle_number)->first();
if($res){
    return back()->with('error', 'Vehicle is already registered ');
}else{


// Create a new instance of the Vehicleregister model
$vehicleregister = new Vehicleregister();


// Assign common data
$vehicleregister->vcat = $request->addVcat;
$vehicleregister->brand = $request->brand;
$vehicleregister->model = $request->model;
$vehicleregister->year = $request->year;
$vehicleregister->vehicle_number = $request->vehicle_number;
$vehicleregister->mielage = $request->mielage;
$vehicleregister->newMiledge=$request->mielage;
$vehicleregister->lice_start = $request->lice_start;
$vehicleregister->lice_end = $request->lice_end;
$vehicleregister->insu_start = $request->insu_start;
$vehicleregister->insu_end = $request->insu_end;
$vehicleregister->registerdate = $request->registerdate;

$vehicleregister->chasis = $request->chasis;
$vehicleregister->engine_number = $request->engine_number;
$vehicleregister->vehicle_color = $request->vehicle_color;

$vehicleregister->owner_type=$request->owner_type;
// Check if "Other Owner" is selected
if ($request->input('owner_type') == 'other Owner') {
    // Assign additional owner details
    $request->validate([
        'owner_fname'=>'required',
        'owner_id'=>'required',
        'owner_phone_number'=>'required',
        'address'=>'required',
        'agreed_miledge'=>'required',
        'agreed_payment'=>'required'
    ]);
    $vehicleregister->address = $request->address;
    $vehicleregister->owner_fname = $request->owner_fname;
    $vehicleregister->owner_id = $request->owner_id;
    $vehicleregister->owner_phone_number = $request->owner_phone_number;

$currentYearMonthDay = Carbon::now()->format('Y-m-d');
$ownerPay = new OwnerPayment();

$ownerPay->vnumber = $request->input('vehicle_number');
$ownerPay->vname = $request->brand . ' ' . $request->model;
$ownerPay->owner_name = $request->input('owner_fname');
$ownerPay->phone_number = $request->input('owner_phone_number');
$ownerPay->agreed_miledge = $request->input('agreed_miledge');//
$ownerPay->agreed_payment = $request->input('agreed_payment');//
$ownerPay->liesence_renew_cost = "0"; 
$ownerPay->liesence_renew_date = "havent renew yet"; 
$ownerPay->previous_mile = $request->input('mielage');
$ownerPay->additional_mile = "0";
$ownerPay->previous_pay_date = $currentYearMonthDay;
$ownerPay->status="unpaid";

$ownerPay->save();

}

 try {
// Save the data to the database
$vehicleregister->save();
$vehicleId = $vehicleregister->id;

$data = new liecence_renew();

$data->vehicle_id = $vehicleId;
$data->brand = $request->brand;
$data->model = $request->model;
$data->vehicle_number = $request->vehicle_number;
$data->expire_date = $request->lice_end;
$data->renew_cost = "0";

$data->save();

$dataset2 = new InsuRenew();

$dataset2->vehicle_id = $vehicleId;
$dataset2->brand = $request->brand;
$dataset2->model = $request->model;
$dataset2->vehicle_number = $request->vehicle_number;
$dataset2->expire_date = $request->insu_end;

$dataset2->save();


$re="Yard in";
$statusData=[
'vehicle_id' => $vehicleId,   'vehicle_name' => $request->brand . ' ' . $request->model ,'vehicle_number'=> $request->vehicle_number  ,'out_mileage'=>$request->mielage  ,'in_mileage'=>$request->mielage ,'reason'=>$re


];
//dd($data);
$vs="available";
$bs="No Bookings";
$zero="0";
// $availableData=[
// 'vehicle_number'=> $request->vehicle_number,'vehicle_name' => $request->brand . ' ' . $request->model ,'vehicle_status'=>$vs  ,'reason'=>$re,'booking_status'=>$bs,'book_date'=>$zero,
//             'release_date'=>$zero
// ];

$miledge=[
'vehicle_reg_id'=> $vehicleId,'vehicle_number'=>$request->vehicle_number, 
'vehicle_name' => $request->brand . ' ' . $request->model ,'mielage' =>$request->mielage
];

$tocheckvehicle=[
'vcat'=>$request->addVcat,'brand'=> $request->brand, 'model'=>$request->model, 'vehicle_number'=>$request->vehicle_number
];

Vehicle_status::create($statusData);
Vehicle::create($tocheckvehicle);
// //VehicleAvaorUna::create($availableData);
Vehicle_reg_mielage::create($miledge);

$this->vehicleService->currentStatusadding($request, $request->brand . ' ' . $request->model, $request->vehicle_number,"Yard in");

// Redirect back with a success message
return back()->with('success', 'Vehicle registered successfully');
} catch (\Exception $e) {
        // If any exception occurs during data insertion, return error message
    dd($e);
        return back()->with('error', 'Failed to register vehicle: '. $e->getMessage());
    }
}


   
}

//update vehicle
public function vehicleUpdate($id, Request $request)
{
    $request->validate([
        'year' => 'required',
        'lice_start' => 'required',
        'lice_end' => 'required',
        'insu_start' => 'required',
        'insu_end' => 'required',
        'registerdate' => 'required',
        'chasis' => 'required',
        'engine_number' => 'required',
        'vehicle_color' => 'required',
    ]);

    if ($request->input('owner_type') == 'other Owner') {
        // Validate additional owner details
        $request->validate([
            'owner_fname' => 'required',
            'owner_id' => 'required',
            'owner_phone_number' => 'required',
            'address2'=>'required'
        ]);
    }

    // Build the data array for update
    $data = [
        
        'year' => $request->year,
        'lice_start' => $request->lice_start,
        'lice_end' => $request->lice_end,
        'insu_start' => $request->insu_start,
        'insu_end' => $request->insu_end,
        'registerdate' => $request->registerdate,
        'chasis' => $request->chasis,
        'engine_number' => $request->engine_number,
        'vehicle_color' => $request->vehicle_color,
        'owner_type' => $request->owner_type,
    ];

if ($request->input('showBrand') == 'No Previous Brand') {

        $data['brand'] = $request->brand;
        $vehiData['brand']= $request->brand;
}else{
    
        $data['brand'] = $request->showBrand;
        $vehiData['brand']= $request->showBrand;

}
if ($request->input('showModel') == 'No Previous Model') {
        $data['model'] = $request->model2;
        $vehiData['model']= $request->model2;
}else{
    
        $data['model'] = $request->showModel;
        $vehiData['model']= $request->showModel;
}
if ($request->input('showVact') == 'No Previous Category') {
        $data['vcat'] = $request->addVcat2;
        $vehiData['vcat']= $request->addVcat2;
}else{
    
        $data['vcat'] = $request->showVact;
        $vehiData['model']= $request->showVact;
}
    // Check if "Other Owner" is selected and add additional owner details to the data array
    if ($request->input('owner_type') == 'other Owner') {
        $data['owner_fname'] = $request->owner_fname;
        $data['owner_id'] = $request->owner_id;
        $data['owner_phone_number'] = $request->owner_phone_number;
        $data['address'] = $request->address2;
    }

    $condition = [
        'id' => $id
    ];
    $conditionOther = [
        'vehicle_id' => $id
    ];



if (!empty($request->brand)) {
    $dataLiece['brand'] = $request->brand;
}
if (!empty($request->model2)) {
    $dataLiece['model'] = $request->model2;
}
if (!empty($request->lice_end)) {
    $dataLiece['expire_date'] = $request->lice_end;
}



if (!empty($request->insu_end)) {
    $datainsu['expire_date'] = $request->insu_end;
}
if (!empty($request->brand)) {
    $datainsu['brand'] = $request->brand;
}
if (!empty($request->model2)) {
    $datainsu['model'] = $request->model2;
}





    try {
        // Update the Vehicleregister record

        Vehicleregister::where($condition)->update($data);
        $updatedRecord = Vehicleregister::where($condition)->first();
        $getVehiclename = $updatedRecord->brand.' '.$updatedRecord->model;

        liecence_renew::where($conditionOther)->update($dataLiece);
        InsuRenew::where($conditionOther)->update($datainsu);
        Vehicle::where('vehicle_number',$request->vehicle_number)->update($vehiData);

        if (!empty($request->owner_fname)) {
    $ownerPayUpdate['owner_name'] = $request->owner_fname;
}
if (!empty($request->owner_phone_number)) {
    $ownerPayUpdate['phone_number'] = $request->owner_phone_number;
}
if (!empty($request->model2) || !empty($request->brand)) {
    $ownerPayUpdate['vname'] = $getVehiclename;
}

if (!empty($request->owner_agreed_miledge)) {
    $ownerPayUpdate['agreed_miledge'] = $request->owner_agreed_miledge;
}
if (!empty($request->owner_agreed_payment)) {
    $ownerPayUpdate['agreed_payment'] = $request->owner_agreed_payment;
}


if (!empty($request->model2) || !empty($request->brand)) {
    $vehicStatus['vehicle_name'] = $getVehiclename;
}
if (!empty($request->model2) || !empty($request->brand)) {
    $dashVehi['vname'] = $getVehiclename;
}
if (!empty($request->model2) || !empty($request->brand)) {
    $dashVehi['vname'] = $getVehiclename;
}
if (!empty($request->model2) || !empty($request->brand)) {
    $regmileV['vehicle_name'] = $getVehiclename;
}

        OwnerPayment::where('vnumber',$request->vehicle_number)->update($ownerPayUpdate);
        Vehicle_status::where($conditionOther)->update($vehicStatus);
        DashBoardvehicle::where('vnumber',$request->vehicle_number)->update($dashVehi);
        Vehicle_reg_mielage::where('vehicle_reg_id',$id)->update($regmileV);
        // Redirect back with a success message
        return back()->with('success', 'Vehicle updated successfully');
    } catch (\Exception $e) {
        // If any exception occurs during data update, return error message
        dd($e->getMessage());
        return back()->with('error', 'Failed to update vehicle: ' . $e->getMessage());
    }
}





//delete vehicle
public function vehicleDelete($id) {
    try {
        // Retrieve the vehicle record by ID
        $vehicle = Vehicleregister::findOrFail($id);
        
        // Retrieve the vehicle number
        $vehiclenumber = $vehicle->vehicle_number;

        
        $vehicleAvailable = Vehicle::where('vehicle_number', $vehiclenumber)->first();

       
        if ($vehicleAvailable) {
            
            $vehicleAvailable->delete();
        } else {
            
            return back()->with('success','Vehicle not found in Vehicle model.');
        }

        $dashvehi=DashBoardvehicle::where('vnumber', $vehiclenumber)->first();
       $dashvehi->delete();
        $vehicle->delete();
        $ownerPay=OwnerPayment::where('vnumber', $vehiclenumber)->first();
       $ownerPay->delete();


        $regVehiMile=Vehicle_reg_mielage::where('vehicle_reg_id',$id)->first();
        $regVehiMile->delete();
        return back()->with('success', 'Vehicle deleted successfully.');

    } catch (Exception $e) {
        // Handle any exceptions
        return back()->with('error', 'Could not delete vehicle. ' . $e->getMessage());
    }
}






// show customer registration
public function cusReg(Request $request)
{
    $query = $request->input('search');
    

    // Start building the query
    $customerQuery = CustomerReg::latest();

    // Check if there's a search query for customer name
    if ($query) {
        $customerQuery->where('fname', 'like', '%' . $query . '%');
    }

    

    // Execute the query and paginate the results
    $customer = $customerQuery->paginate(6);

    return view('inf.customerReg', compact('customer'));
}
// save customer registration
public function savecusReg(Request $request){
    $request->validate([
    
        'fname' => 'required',
        'lname' => 'required',
        'dob' => 'required',
       'phonenumber' => 'required',
            'address' => 'required',
            'vip_or_nonvip' => 'required',
            'regDate' => 'required',
            
            'whatsappnumber'=> 'required'
           
        
        
    ]);
//+ ($request->input('large-select') === 'nic' ? ['idnumber' => 'required'] : ['passportnumber' => 'required'])
    $vehicleregister = new CustomerReg();
    
        
        if ($request->has('idnumber')) {
    $vehicleregister->idnumber = $request->input('idnumber');
}

// Check if "passportnumber" is present in the request
if ($request->has('passportnumber')) {
    $vehicleregister->passportnumber = $request->input('passportnumber');
}

// Check if "liecencenumber" is present in the request
if ($request->has('liecencenumber')) {
    $vehicleregister->liecencenumber = $request->input('liecencenumber');
}
    $vehicleregister->whatsappnumber = $request->whatsappnumber;
    // Assign common data
    $vehicleregister->fname = $request->fname;
    $vehicleregister->lname = $request->lname;
    $vehicleregister->dob = $request->dob;
    
    $vehicleregister->phonenumber = $request->phonenumber;
    $vehicleregister->address = $request->address;
    $vehicleregister->vip_or_nonvip = $request->vip_or_nonvip;
    $vehicleregister->regDate = $request->regDate;

    $vehicleregister->mobile_op = $request->phonenumber_op;
    $vehicleregister->address_op = $request->address_op;

    
    $res=$vehicleregister->save();
    if($res){
        return back()->with('success', 'Customer registered successfully');
    }else{
        return back()->with('fail', 'Customer not registered successfully');
    }




}


//get suggetion data
public function getVehicleSuggestions(Request $request)
    {
        // Get the query parameter from the request
        $query = $request->input('query');

        // Query the VehicleRegister model for suggestions
        $suggestions = VehicleRegister::where('vehicle_number', 'like', "%$query%")
                                      ->pluck('vehicle_number');

        // Return the suggestions as JSON response
        return response()->json($suggestions);
    }

//get vehicle status
public function getVehicleStatus(Request $request){
$vnumber = $request->input('vnumber');
    $st = DashBoardvehicle::where('vnumber', $vnumber)->pluck('current_status')->first();
    return response()->json($st);
}
//show vehicle table
public function showLiesenceRenew(){
return view('inf.car_liecence');
}


//get logged user real time
public function stream()
    {
        $response = new StreamedResponse(function () {
            while (true) {
                $users = User::select('fname')->where('status', 1)->get();

                echo "data: " . json_encode($users) . "\n\n";
                ob_flush();
                flush();

                sleep(5); // Adjust the interval as needed
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }


}