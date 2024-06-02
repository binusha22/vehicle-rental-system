<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CustomerReg;
use App\Models\VehicleRegister;

class FetchBirthday
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
{
    $currentDate = now()->format('m-d');

    $notificationsBirthday = CustomerReg::whereRaw("DATE_FORMAT(DATE_SUB(dob, INTERVAL 2 DAY), '%m-%d') = ?", [$currentDate])
                        ->get();
$vehicleCount = VehicleRegister::whereNotNull('id')->count();
    // Calculate notification count
    $birthdaynotificationCount = $notificationsBirthday->count();

    // Share data with all views
    view()->share('notificationsBirthday', $notificationsBirthday);
    view()->share('birthnotificationCount', $birthdaynotificationCount);
    view()->share('vehicleCount', $vehicleCount);
    
    return $next($request);
}




}
