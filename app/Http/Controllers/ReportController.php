<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customerpayment;
use App\Models\CustomerDeposit;
use App\Models\Vehicle;
use App\Models\OwnerPayment;
use App\Models\Ownerpaydetails;
use App\Models\User;
use App\Models\Salarey;
use App\Models\DashBoardvehicle;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleNumbers=Vehicle::select('vehicle_number','brand','model')->get();
        
        $empNames=User::select('id','fname','lname')->get();
        $ownersNames=OwnerPayment::select('owner_name')->get();
        $customerNames=CustomerDeposit::select('cus_id','name')->get();
        return view('inf.report',compact('customerNames','vehicleNumbers','ownersNames','empNames'));
    }

    //get customer details oto report
    public function getCustomerPayments(Request $request)
{
    $cusid = $request->input('cusid');
     $start_date = $request->input('sdate');
    $end_date = $request->input('edate');

    $query = Customerpayment::query();

    if ($cusid) {
        // Fetch customer payment data based on the customer ID
        $query->where('customer_id', $cusid);
    }
    if ($start_date && $end_date) {
        // Fetch customer payment data between start_date and end_date
        $query->whereBetween('payment_date', [$start_date, $end_date])
              ->where('customer_id', $cusid); // Add condition for customer_name
    }

    $payments = $query->get();

    // Return the data as JSON
    return response()->json(['payments' => $payments]);
}



//get owner payment report
public function getOwnerPayments(Request $request){
$vehicleNumber=$request->input('vnumber');
 $ownerName=$request->input('name');
 $startDate=$request->input('startDate');
$endDate=$request->input('endDate');

$query=Ownerpaydetails::query();

if($vehicleNumber){
    $query->where('vnumber',$vehicleNumber);
}
if($ownerName){
    $query->where('owner_name',$ownerName);
}
if($vehicleNumber && $ownerName){
    $query->where('vnumber',$vehicleNumber)->where('owner_name',$ownerName);
}
if ($vehicleNumber && $ownerName && $startDate && $endDate) {
    $query->where('vnumber', $vehicleNumber)
          ->where('owner_name', $ownerName)
          ->whereBetween('previous_pay_date', [$startDate, $endDate]);
}

$data=$query->get();
return response()->json(['data' => $data]);
}

//get data to vehicle income report
public function getVehicleIncome(Request $request) {
    $vehicleNumber = $request->input('vnumber');
    $vehicleName = $request->input('vname');
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    $query = Customerpayment::query();

    $vname = $vehicleNumber;
    if ($vehicleNumber) {
        $query->where('vehicle_number', $vehicleNumber);
        //$vname = DashBoardvehicle::where('vnumber', $vehicleNumber)->pluck('vname')->first();
    }

    if ($vehicleNumber && $startDate && $endDate) {
        $query->where('vehicle_number', $vehicleNumber)->whereBetween('payment_date', [$startDate, $endDate]);
    }

    $data = $query->get();
    return response()->json(['data' => $data, 'vname' => $vname]);
}







//get data to salary report
public function getSalaryReport(Request $request){


$empid=$request->input('empName');
 $startDate=$request->input('startDate');
$endDate=$request->input('endDate');


$query=Salarey::query();
if($empid){
    $query->where('EmpnId',$empid);
}
if($empid && $startDate && $endDate){
    $query->where('EmpnId',$empid)->whereBetween('addDate', [$startDate, $endDate]);
}
    $data=$query->get();
return response()->json(['data' => $data]);
}



//test
public function openTestMile(Request $request){

return view('inf.new');

}

public function submitTestMile(Request $request){

    $start=$request->st;
    $end=$request->ed;

$total=null;
    if($end < 100000 && $end < $start){

        $subtotal=100000-$start;
        $total=$subtotal+$end;

    }else{
        $total=$end-$start;
    }
    dd($total);
}

}
