<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\Booking;
use App\Models\User;
use App\Models\Staks;
use App\Models\Svalues;
use App\Models\CustomerDeposit;
use App\Models\Attendence;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
       

    $userId = session('loginId');
    $con=['get_mileage','get_end_gas','get_end_mileage','normal','get_gas','ready_vehicle'];
    $tasks = Task::where('user_id', $userId)
                    ->whereIn('task_type',$con)
                   ->where('status', 'uncomplete')->get();

                   
$uploadTask = Task::where('user_id', $userId)
                   ->where('status', 'uncomplete')
                   ->where('task_type','upload_images')->get();



$staksData = Staks::with(['svalues' => function ($query) {
        $query->where('status', 'uncomplete');
    }])
    ->where('status', 'uncomplete') // Filter Staks based on status
    ->where('user_id', $userId)
    ->get();

    return view('inf.task', compact('tasks','staksData','uploadTask'));
}



public function openUploadpage(){

    return view('inf.task_upload');

}

public function getInvoiceNumber($taskId)
{
    $task = Task::find($taskId);
    if ($task) {
        $invoiceNumber = $task->inv;
        error_log("Invoice number: " . $invoiceNumber); // Logging the invoice number
        return response()->json(['invoiceNumber' => $invoiceNumber]);
    } else {
        return response()->json(['error' => 'Task not found'], 404);
    }
}

public function getInvoice($id){
        $task = Task::find($id);
        $inv=$task->inv;
    return view('inf.task_upload',['inv'=>$inv]);
}


    //upload image task
  public function uploadTaskImageAndData(Request $request)
{
    try {
        $request->validate([
    'miledge' => $request->input('task_type') === 'get_mileage' ? 'required' : '',
    'endmiledge' => $request->input('task_type') === 'get_end_mileage' ? 'required' : '',
    'endgas' => $request->input('task_type') === 'get_end_gas' ? 'required' : '',
    'imageGas'=> 'image'
], [
    'gas.required' => 'Please add gas level',
    'imageGas.image'=> 'Choose Image 15 must be a valid image file'
]);

if ($request->input('task_type') === 'normal') {
            $taskId = $request->input('task_id');
        $task = Task::findOrFail($taskId);
        if ($task->status === 'complete') {
                return redirect()->back()->with('f', 'This task is already completed.');
        }

        
        
        $task->update(['status' => 'complete']);
        return redirect()->back()->with('s', 'Data uploaded successfully.');

        }
        $invNumber = $request->section_id; // Get invoice number

        // Save images to the desired location
//         $imageUrls = [];
       

//             foreach (range(1, 15) as $index) {
//     $imageField = 'image' . $index;
//     $image = $request->file($imageField);

//     // Check if a file was uploaded
//     if ($image) {
//         // Create an Intervention Image instance
//         $imageInstance = Image::make($image->getPathname());

//         // Resize and compress the image to be under 1MB
//         // You can adjust the width and height as needed
//         $imageInstance->resize(1024, null, function ($constraint) {
//             $constraint->aspectRatio();
//             $constraint->upsize();
//         });

//         // Save the image with quality parameter (0-100)
//         // The lower the quality, the smaller the file size
//         $imageName = 'image_' . $index . '_' . time() . '.' . $image->getClientOriginalExtension();
//         $imagePath = storage_path('app/public/app-assets/images/avotas/' . $imageName);
//         $imageInstance->save($imagePath, 75); // Adjust quality to reduce file size

//         // Store the relative path to the image
//         $imageUrls[] = 'app-assets/images/avotas/' . $imageName;
//     }
// }


        // Update database with image URLs
        $booking = Booking::where('invoice_number', $invNumber)->firstOrFail();
        if ($request->input('task_type') === 'get_mileage') {
            $booking->s_mileage = $request->input('miledge');
            $stt="On going";
            $booking->status=$stt;
        }

        if ($request->input('task_type') === 'get_gas') {
            
            $booking->fual = $request->input('gas') ?? 0;

            // Check if a file was uploaded
                if ($request->hasFile('imageGas')) {
                    // Get the uploaded file
                    $imageGas = $request->file('imageGas');
                    
                    // Generate a unique filename for the image
                    $filename = uniqid('image_gas_') . '.' . $imageGas->getClientOriginalExtension();
                    
                    // Store the image in the storage directory
                    $imageGas->storeAs('public/app-assets/images/avotas', $filename);
                    
                    // Set the image URL in the database column
                    $booking->uploadGasImg = 'app-assets/images/avotas/' . $filename;
                }
        }
        if ($request->input('task_type') === 'get_end_mileage') {
            
            $endMile=$request->input('endmiledge');
            $startMile=$booking->s_mileage;
            $costperkm=$booking->additonal_cost_km;
            $agreedMile=$booking->agreedmile;
            $tripRange=$endMile-$startMile;
            $additionalMile=$tripRange-$agreedMile;
            $totalcostofadditionalmile=$additionalMile * $costperkm;

            $stt="pending";//waiting for final payment
            $booking->e_mileage=$endMile;
            $booking->trip_range=$tripRange;
            $booking->additinalMile=$additionalMile;

            $booking->status=$stt;

            //update deposit table

            // $depos = CustomerDeposit::where('invoice', $invNumber)->firstOrFail();
            // $depositTable=$depos->deposit;
            // $rest=$depositTable-$totalcostofadditionalmile;
            // $condition=[
            //         'invoice'=>$invNumber
            // ];

            // $deposiData=[
            //     'current_deposit'=>$rest
            // ];

            // CustomerDeposit::where($condition)->update($deposiData);
        }
        if ($request->input('task_type') === 'get_end_gas') {
            $booking->end_fual = $request->input('endgas');
        }
        // if ($request->input('task_type') === 'upload_images') {
        //     $imgsss=implode(',', $imageUrls);
        //     $booking->uploadImage_url = $imgsss; // Save image URLs separated by comma
            
        // }



        $taskId = $request->input('task_id');
        $task = Task::findOrFail($taskId);
        if ($task->status === 'complete') {
                return redirect()->back()->with('f', 'This task is already completed.');
        }

        $booking->save();
        if ($request->input('task_type') === 'upload_images') {
            $imgsss=implode(',', $imageUrls);
            $task->update(['imageUrl' => $imgsss]);
        }
        $task->update(['status' => 'complete']);

        return redirect()->back()->with('s', 'Data uploaded successfully.');
    } catch (Exception $e) {
        return redirect()->back()->with('f', 'Failed to upload data.');
    }
}
//uploadimages task
public function uploadImagestask(Request $request){
try {
        $request->validate([
    'image1' => 'image',
    'image2' => 'image',
    'image3' => 'image',
    'image4' => 'image',
    'image5' => 'image',
    'image6' => 'image',
    'image7' => 'image',
    'image8' => 'image',
    'image9' => 'image',
    'image10' => 'image',
    'image11' => 'image',
    'image12' => 'image',
    'image13' => 'image',
    'image14' => 'image',
    'image15' => 'image',
    'imageGas'=> 'image'
], [
    'image1.image' => 'Choose Image 1 must be a valid image file',
    'image2.image' => 'Choose Image 2 must be a valid image file',
    'image3.image' => 'Choose Image 3 must be a valid image file',
    'image4.image' => 'Choose Image 4 must be a valid image file',
    'image5.image' => 'Choose Image 5 must be a valid image file',
    'image6.image' => 'Choose Image 6 must be a valid image file',
    'image7.image' => 'Choose Image 7 must be a valid image file',
    'image8.image' => 'Choose Image 8 must be a valid image file',
    'image9.image' => 'Choose Image 9 must be a valid image file',
    'image10.image' => 'Choose Image 10 must be a valid image file',
    'image11.image' => 'Choose Image 11 must be a valid image file',
    'image12.image' => 'Choose Image 12 must be a valid image file',
    'image13.image' => 'Choose Image 13 must be a valid image file',
    'image14.image' => 'Choose Image 14 must be a valid image file',
    'image15.image' => 'Choose Image 15 must be a valid image file'
]);

$taskID = $request->task_id;
$invNumber = $request->section_id; // Get invoice number


$booking = Booking::where('invoice_number', $invNumber)->firstOrFail();


 // Save images to the desired location
        $imageUrls = [];
       

            foreach (range(1, 15) as $index) {
                $imageField = 'image' . $index;
                $image = $request->file($imageField);

                // Check if a file was uploaded
                if ($image) {
                    $imageName = 'image_' . $index . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/app-assets/images/avotas', $imageName);
                    $imageUrls[] = 'app-assets/images/avotas/' . $imageName;
                }
            }

$imgsss=implode(',', $imageUrls);
 $booking->uploadImage_url = $imgsss;

$booking->save();
 $task = Task::findOrFail($taskID);
$task->update(['status' => 'complete']);



        return redirect()->back()->with('s', 'Data uploaded successfully.');
    } catch (Exception $e) {
        return redirect()->back()->with('f', 'Failed to upload data.');
    }
}

    public function fetchImagesByEmployee()
{
    try {
    // Fetch bookings
    $bookings = Booking::all();

    // Check if any bookings were found
    if ($bookings->isEmpty()) {
        return redirect()->back()->with('error', 'No bookings found for the selected employee.');
    }

    // Pass the bookings data to the view
    return view('inf.task_upload', compact('bookings'));
} catch (Exception $e) {
    return redirect()->back()->with('error', 'Failed to fetch images.');
}
}


//assign normal task
public function assign_normal_task(Request $request){

    $activeUsers=Attendence::where('status','IN')->get();
    $userId = session('loginId');
    $task=Task::orderBy('id','desc')->paginate(15);
    return view('inf.full_task',compact('activeUsers','task'));
}

public function fetch_task_of_employee(Request $request){

$uid = $request->input('name');
    $date = $request->input('date');
$data=Task::where('user_id',$uid)->where('date',$date)->get();
    return response()->json($data);

}
public function insert_normal_task(Request $request){

try {
        $request->validate([
            'selctedEmp' => 'required',
            'getDate' => 'required',
            'Description' => 'required',
            
        ]);
$st="uncomplete";
$type="normal";

$checkuser=Attendence::where('user_id',$request->selctedEmp)->pluck('name')->first();
        
          $data = [
    'user_id' => $request->selctedEmp,
    'name' => $checkuser,
    'date' => $request->getDate,
    'task_desc' => $request->Description,
    'status' => $st,
    'task_type' => $type,
];

Task::insert([$data]);
        return back()->with('s', 'Assigned the employee successfully');
        
    } catch (Exception $e) {
        return back()->with('f', 'Could not add the employee');
    }


}


public function fetchDescription(Request $request)
    {
        // Fetch description data based on tid
        $td = $request->input('tt');
        $task = Task::where('id', $td)->first();

        // Check if task exists
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Return description data
        return response()->json(['task_desc' => $task->task_desc,'taskid'=>$td]);
    }



public function fetchImages(Request $request)
{
    $invoiceNumber = $request->invoice;
    // Assuming you have a Booking model
    $booking = Booking::where('invoice_number', $invoiceNumber)->first();
    $imageUrls = explode(',', $booking->uploadImage_url);
    return response()->json($imageUrls);
}
public function fetchGasImages(Request $request)
{
    $invoiceNumber = $request->invoice;
    // Assuming you have a Booking model
    $booking = Booking::where('invoice_number', $invoiceNumber)->first();
    $imageUrls = $booking->uploadGasImg;
    return response()->json($imageUrls);
}


//edittask description
public function editTaskDescription(Request $request){
    $ids=$request->input('descID');
    $desc=$request->input('taskDesc3');

    Task::where('id',$ids)->update(['task_desc'=>$desc]);
    return back()->with('s', 'Edited the Description successfully');
}

}
