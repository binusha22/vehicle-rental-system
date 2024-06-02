<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LiecenceRenewController;
use App\Http\Controllers\InsuRenewController;
use App\Http\Controllers\Vehicle_statusController;
use App\Http\Controllers\EmployeemanageController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\BookController;
use App\Http\Livewire\CustomerTable;
use App\Http\Controllers\CarmaintainCotroller;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TripDetailsController;
use App\Http\Controllers\CustomerpayController;
use App\Http\Controllers\VehiclereplaceController;
use App\Http\Controllers\OwnerpayController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//laravel 9 walata route kohomd hdnne kiyla chat gpt hri normal google hri hrl blhan
//controller hadan ekath ehemei

Route::get('/', function () {
    return view('auth.login');
});

//admin controller
Route::get('/home2', [AdminController::class, 'displyHome'])->name('home2')->middleware('is_Not_login');
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login')->middleware('is_already_log_in');
Route::post('/login-user', [AdminController::class, 'login_user'])->name('login-user');
Route::get('/logout',[AdminController::class,'userLogout'])->name('logout')->middleware('is_Not_login');
// routes/web.php
Route::get('/sse/logged-in-users', [AdminController::class, 'loggedUsers']);


Route::get('/msg', [AdminController::class, 'msg'])->name('msg');

Route::post('/store-token', [AdminController::class, 'updateDeviceToken'])->name('store.token');

    Route::post('/send-web-notification', [AdminController::class, 'sendNotification'])->name('send.web-notification');




//Admin routes and Dashboard
Route::middleware(['isadmin'])->prefix('/admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'admin_dash'])->name('admin.dashboard');
    Route::get('/register', [AdminController::class, 'showRegForm'])->name('admin.register');
    Route::post('/register-user', [AdminController::class, 'reg_user'])->name('register-user');
    Route::put('/users_update/{id}', [AdminController::class, 'userUpdate'])->name('users_update');
    Route::delete('/delete_user/{id}', [AdminController::class, 'userDlete'])->name('delete_user');


});
//vehicle registraion route
Route::get('/car_registration', [FormController::class, 'car_registration'])->name('car_registration')->middleware('check_user_role');//registration page open



Route::get('/get-vehicle-suggestions', [FormController::class, 'getVehicleSuggestions'])->name('getVehicleSuggestions');
Route::get('/get-vehicle-status', [FormController::class, 'getVehicleStatus'])->name('get_vehicle_status');
Route::post('/add-brand', [FormController::class, 'insertBrand'])->name('add-brand');
Route::post('/add-cat', [FormController::class, 'insertCat'])->name('add-cat');
Route::get('/load-cat', [FormController::class, 'loadCat'])->name('load-cat');
Route::get('/load-brand', [FormController::class, 'loadBrand'])->name('load-brand');//json route
Route::post('/add-model', [FormController::class, 'insertModel'])->name('add-model');
Route::get('/get-models/{brandId}/{catId}', [FormController::class, 'loadModel'])->name('get-models');//json 
Route::get('/get-vcat/{brandId}', [FormController::class, 'loadBrandInFrom'])->name('get-vcat');
Route::post('/vehicle-register', [FormController::class, 'vehicleRegister'])->name('vehicle-register');
//register vehicle and send data to database
Route::put('/vehicle_update/{id}', [FormController::class, 'vehicleUpdate'])->name('vehicle_update');
Route::delete('/setvehicledelete/{id}', [FormController::class, 'vehicleDelete'])->name('setvehicledelete');

Route::get('/user-status-stream', [FormController::class, 'stream']);

//vehicle registraion route end here

//vehicle liecence renew route
Route::get('/vehicle-liecence-renew', [LiecenceRenewController::class, 'index'])->name('vehicle-liecence-renew')->middleware('check_user_role');
Route::post('/vehicle-liecence-renew-data-insert', [LiecenceRenewController::class, 'insertVehicleRenew'])->name('vehicle-liecence-renew-data-insert');

Route::get('/vehicle-search', [LiecenceRenewController::class, 'searchVehicles'])->name('vehicle-search');

//vehicle insuarence renew route
Route::get('/vehicle-insuarence-renew', [InsuRenewController::class, 'index'])->name('vehicle-insuarence-renew')->middleware('check_user_role');
Route::post('/vehicle-insuarence-renew-data-insert', [InsuRenewController::class, 'insertVehicleRenew'])->name('vehicle-insuarence-renew-data-insert');

//vehicle status routes
Route::get('/vehicle-status', [Vehicle_statusController::class, 'index'])->name('vehicle-status')->middleware('check_user_role');
Route::get('/get-data/{vehicle_id}', [Vehicle_statusController::class, 'loadData'])->name('get-data');//json
Route::post('/vehicle-status-out-vehicle', [Vehicle_statusController::class, 'insertDetails'])->name('vehicle-status-out-vehicle');
Route::post('/vehicle-status-in-vehicle', [Vehicle_statusController::class, 'insertDetails2'])->name('vehicle-status-in-vehicle');
Route::get('/get_vehicle_reason',[Vehicle_statusController::class,'filterVehicleReason']);


//Employee Manage 
Route::get('/manage_employee', [EmployeemanageController::class, 'index'])->name('manage_employee')->middleware('isadmin');
Route::post('/update_ot', [EmployeemanageController::class, 'updateOT'])->name('update_ot');
Route::post('/submit_leave', [EmployeemanageController::class, 'submitLeave'])->name('submit_leave');
Route::post('/deny_leave', [EmployeemanageController::class, 'denyLeave'])->name('deny_leave');
Route::post('/inset_salary', [EmployeemanageController::class, 'inset_salary'])->name('inset_salary');
Route::get('/get-attendance', [EmployeemanageController::class, 'getAttendance'])->name('get-attendance');
Route::get('/reuest_leave', [EmployeemanageController::class, 'LeaveRequest'])->name('reuest_leave');
Route::get('fetch_submited_data', [EmployeemanageController::class, 'fetch_submited_data'])->name('fetch_submited_data');
Route::get('/fetch_salary_of_emp', [EmployeemanageController::class, 'fetch_salary_of_emp'])->name('fetch_salary_of_emp');
Route::get('/fetch_attendence_of_emp', [EmployeemanageController::class, 'fetch_attendence_of_emp'])->name('fetch_attendence_of_emp');
Route::post('/send_leave_request', [EmployeemanageController::class, 'LeaveRequestInsert'])->name('send_leave_request');
Route::get('/fetch_overtime', [EmployeemanageController::class, 'fetch_overtime'])->name('fetch_overtime');


//employee attendence
Route::get('/employee-attendence', [AttendenceController::class, 'index'])->name('employee-attendence')->middleware('check_user_role');
Route::post('/employee_attendence_in', [AttendenceController::class, 'attendenceIn'])->name('employee_attendence_in');
Route::post('/emp-check-out', [AttendenceController::class, 'attendenceOut'])->name('emp-check-out');


//booking
Route::get('/booking', [BookController::class, 'index'])->name('booking')->middleware('check_user_role');//json
Route::get('/get_models_booking/{brandId}/{vcat}', [BookController::class, 'loadModel'])->name('get_models_booking');

Route::get('/fetch-data', [BookController::class,'fetchData'])->name('fetchData');//json
Route::get('/fetchFilteredData', [BookController::class,'fetchFilteredData'])->name('fetchFilteredData');//json
Route::get('fetch_customer', CustomerTable::class)->name('fetch_customer');
Route::post('/insert_booking_data', [BookController::class, 'insertBooking'])->name('insert_booking_data');
Route::post('/assign_employee', [BookController::class, 'assignEmployee'])->name('assign_employee');
Route::post('/assign_employee_book', [BookController::class, 'assignEmployeebook'])->name('assign_employee_book');
Route::get('/filter_booking', [BookController::class, 'filterBooking'])->name('filter_booking');
Route::get('/getEmployeeNames', [BookController::class, 'getEmployeeNames'])->name('getEmployeeNames');
Route::get('/sse', [BookController::class, 'sse'])->name('sse');
Route::get('/second_book', [BookController::class, 'second_book'])->name('second_book');
// routes/web.php

Route::get('/fetchDataFromVehicleRegister', [BookController::class,'fetchDataFromVehicleRegister'])->name('fetchDataFromVehicleRegister');
Route::get('/getAvailableVehicle', [BookController::class, 'getAvailableVehicle'])->name('getAvailableVehicle');
Route::post('/extend_booking', [BookController::class, 'extend_booking'])->name('extend');


//invoices invoice
Route::get('/get-invoice', [BookController::class, 'invoice'])->name('invoice')->middleware('check_user_role');
Route::get('/filter-invoices', [BookController::class, 'filterInvoices'])->name('filterInvoices');

Route::get('/get-invoice-details/{invoice}', [BookController::class, 'invoiceDetails'])->name('get_invoice_details')->middleware('check_user_role');

Route::get('/get-invoice-details/{invoiceid}/generate', [BookController::class, 'genarateInvoice'])->name('get_invoice_details_genarate');

Route::get('/loadBrandInFrom', [BookController::class, 'loadBrandInFrom'])->name('loadBrandInFrom');
Route::delete('/delete_booking/{id}',[BookController::class,'deleteBooking'])->name('delete_booking');
//check is the vehicle is in yard or not
Route::get('/vehicle_dash_status', [BookController::class, 'getVehiclePopStatus'])->name('vehicle_dash_status');


//employee task
Route::get('/show_task', [TaskController::class, 'index'])->name('show_task');
Route::get('/show_task_upload', [TaskController::class, 'openUploadpage'])->name('show_task_upload');
Route::post('set_taks', [TaskController::class, 'uploadTaskImageAndData'])->name('set_taks');
Route::get('/fetch_img', [TaskController::class, 'fetchImagesByEmployee'])->name('fetch_img');
Route::get('/assign_normal_task', [TaskController::class, 'assign_normal_task'])->name('assign_normal_task')->middleware('isadmin');
Route::post('/insert_normal_task', [TaskController::class, 'insert_normal_task'])->name('insert_normal_task');
Route::get('/fetch-description/{tid}', [TaskController::class,'fetchDescription'])->name('fetch-description');
Route::get('/fetch_task_of_employee', [TaskController::class,'fetch_task_of_employee'])->name('fetch_task_of_employee');
// routes/web.php
Route::post('/upload-images',[TaskController::class, 'uploadImagestask'])->name('upload_images');
Route::get('/fetch-images', [TaskController::class, 'fetchImages']);
Route::get('/fetch-gas-image',[TaskController::class,'fetchGasImages']);
Route::post('/edit-task-description',[TaskController::class,'editTaskDescription'])->name('edit_task_description');




//trip details
Route::get('/tripdetails', [TripDetailsController::class, 'index'])->name('tripdetails')->middleware('check_user_role');
Route::get('/search', [TripDetailsController::class,'search'])->name('search');
Route::get('/searchsecond', [TripDetailsController::class,'searchsecond'])->name('searchsecond');
Route::get('/searchthredd', [TripDetailsController::class,'searchthredd'])->name('searchthredd');
Route::post('/assign-employee', [TripDetailsController::class,'assignEmp'])->name('assign-employee');




//customer registration route
Route::get('/customer_registration', [FormController::class, 'cusReg'])->name('customer_registration')->middleware('check_user_role');//show customer page
Route::post('/save_customer', [FormController::class, 'savecusReg'])->name('save_customer');

// vehicle liesence renew route
Route::get('/vehicle_liesence_renew', [FormController::class, 'showLiesenceRenew'])->name('vehicle_liesence_renew');//show liesence renew page




//car maintains
Route::get('/car_maintain', [CarmaintainCotroller::class, 'index'])->name('car_maintain')->middleware('check_user_role');
Route::post('/save-checkbox-data', [CarmaintainCotroller::class, 'saveCheckData'])->name('save-checkbox-data');
//complete sub tasks
Route::post('/set_submit', [CarmaintainCotroller::class, 'setDataComplete'])->name('set_submit');
//submit cost and desc
Route::post('/set_submit_service', [CarmaintainCotroller::class, 'setServiceComplete'])->name('set_submit_service');
//submit entire task
Route::post('/set_submit_task', [CarmaintainCotroller::class, 'setTaskcomplete'])->name('set_submit_task');

Route::post('/get_vehicle_names', [CarmaintainCotroller::class, 'getVehicleNames'])->name('get_vehicle_names');
Route::post('/get_vehicle_names_for', [CarmaintainCotroller::class, 'getVehicleNames2'])->name('get_vehicle_names_for');
Route::post('/send-service-data', [CarmaintainCotroller::class, 'sendServicedata'])->name('send_service_data');

Route::get('/get-svalues-data', [CarmaintainCotroller::class, 'getSvaluesData']);
Route::post('/saveToken', [CarmaintainCotroller::class, 'saveToken'])->name('saveToken');




//customer payments  ->middleware('check_user_role')
Route::get('/customer-payments', [CustomerpayController::class, 'index'])->name('customer-payments')->middleware('check_user_role');
Route::post('/insert-customer-payments', [CustomerpayController::class, 'insertData'])->name('insert-customer-payments');
Route::get('/load-invoice-payment', [CustomerpayController::class, 'loadInvoice'])->name('load-invoice-payment');
Route::get('/load-cus-payment', [CustomerpayController::class, 'loadcuspay'])->name('load-cus-payment');

Route::get('/fetch-deposit', [CustomerpayController::class, 'fetchDeposit'])->name('fetchDeposit');
Route::get('/fetch-miledge', [CustomerpayController::class, 'fetchMiledge'])->name('fetchMiledge');

Route::post('insert-final-payment', [CustomerpayController::class, 'insertfinalpay'])->name('insertfinalpay');
Route::post('edit-customer-topay', [CustomerpayController::class, 'edit_topay'])->name('edit_topay');


//vehicle replacement   
Route::get('/vehicle-replacement', [VehiclereplaceController::class, 'index'])->name('vehicle_replacement_page')->middleware('check_user_role');
Route::get('/get-customer-info-replace', [VehiclereplaceController::class, 'getCusInfo'])->name('fetchDataInReplace');
Route::post('insert-new-booking', [VehiclereplaceController::class, 'insertNewBooking'])->name('insert_new_booking');
Route::get('/car-replace/search', [VehiclereplaceController::class,'search'])->name('car-replace.search');



//owner payment 
Route::get('/owner-payment', [OwnerpayController::class,'index'])->name('owner_pay')->middleware('check_user_role');
Route::get('/filter_payments', [OwnerpayController::class, 'filterPayments'])->name('filter_payments');
Route::get('/fetch-service-cost', [OwnerpayController::class, 'filterserviceCost'])->name('fetch-service-cost');
Route::get('/filterservicedetails', [OwnerpayController::class, 'filterservicedetails'])->name('filterservicedetails');
Route::post('/insert-owner-payment-data',[OwnerpayController::class,'store'])->name('insetData');



//report controller
Route::get('/reports',[ReportController::class,'index'])->name('reports');
//genarate reports in customer report
Route::get('/customer-payments-report', [ReportController::class, 'getCustomerPayments']);
Route::get('/customer-payments-report-datewise', [ReportController::class, 'getCustomerPayments']);

//genarate report in owner payment
Route::get('/owner-payment-report', [ReportController::class, 'getOwnerPayments']);
Route::get('/owner-payment-report-datewise', [ReportController::class, 'getOwnerPayments']);

////genarate report in vehicle income report
Route::get('/vehicle-income-report', [ReportController::class, 'getVehicleIncome']);
Route::get('/vehicle-income-report-datewise', [ReportController::class, 'getVehicleIncome']);

//genarate report in emp salary report
Route::get('/salary-report', [ReportController::class, 'getSalaryReport']);
Route::get('/salary-report-datewise', [ReportController::class, 'getSalaryReport']);


Route::get('/open-test',[ReportController::class,'openTestMile']);
Route::post('/sumbit-test',[ReportController::class,'submitTestMile'])->name('sumbit-test');




//Aother user's Dashboards
Route::get('/emp-dashboard',[AdminController::class,'user_dash'])->name('emp-dashboard');
Route::get('/manegment-dashboard',[AdminController::class,'emp_dash'])->name('manegment-dashboard')->middleware('check_user_role');
