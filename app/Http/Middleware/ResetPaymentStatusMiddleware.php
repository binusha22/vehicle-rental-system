<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use App\Models\OwnerPayment;
use Carbon\Carbon;

class ResetPaymentStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the current date and month
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->format('Y-m');
        
        // Check if it's the first day of the month
        if ($currentDate->isSameDay($currentDate->startOfMonth())) {
            // Check if the reset has not been performed for the current month
            if (!Cache::has('last_reset') || Cache::get('last_reset') !== $currentMonth) {
                // Perform the reset operation
                OwnerPayment::where('status', "paid")->update(['status' => "unpaid"]);

                // Update the cache to indicate the reset has been done for this month
                Cache::put('last_reset', $currentMonth, $currentDate->endOfMonth());
            }
        }

        return $next($request);
    }
}

