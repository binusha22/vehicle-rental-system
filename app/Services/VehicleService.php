<?php  
// Create a file: app/Services/VehicleService.php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DashBoardvehicle;

class VehicleService
{
    public function currentStatusadding(Request $request, $name, $number,$st)
    {
        $currentDateTime = Carbon::now();
        $currentDate = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i:s');

        // Check if vehicle number already exists, update if it does, create if it doesn't
        $data = DashBoardvehicle::updateOrCreate(
            ['vnumber' => $number],  // Find by this column
            [
                'vname' => $name,            // Only set if creating
                'current_status' => $st,
                'time' => $currentTime,
                'date' => $currentDate,
            ]
        );

        return response()->json(['success' => true, 'data' => $data]);
    }
}
