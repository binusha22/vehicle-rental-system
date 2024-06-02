<?php

// FetchExpireSoonVehiclesMiddleware.php

namespace App\Http\Middleware;

use Closure;
use App\Models\liecence_renew;
use App\Models\InsuRenew;

class FetchExpireSoonVehiclesMiddleware
{
    public function handle($request, Closure $next)
    {
        $notificationsFromSession = liecence_renew::whereDate('expire_date', '<=', now()->addDays(15)->toDateString())
                            ->whereDate('expire_date', '>=', now()->toDateString())
                            ->get()->map(function ($item) {
                                $item->source = 'liecence_renew';
                                return $item;
                            });
        
        $getInsuData = InsuRenew::whereDate('expire_date', '<=', now()->addDays(15)->toDateString())
                            ->whereDate('expire_date', '>=', now()->toDateString())
                            ->get()->map(function ($item) {
                                $item->source = 'InsuRenew';
                                return $item;
                            });
        
        // Merge data from both tables into a new collection
        $mergedNotifications = $notificationsFromSession->merge($getInsuData);

        // Calculate notification count
        $notificationCount = $mergedNotifications->count();

        $message = $notificationCount > 0 ? ' notifications body is here' : 'No notifications found.';

        // Share data with all views
        view()->share('notificationsFromSession', $mergedNotifications);
        view()->share('notificationCount', $notificationCount);
        view()->share('message', $message);

        return $next($request);
    }
}
