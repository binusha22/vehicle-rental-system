<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Staks;

class FetchTask
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
        $userId = session('loginId');
                    $notificationsFromSession = Task::where('user_id', $userId)->where('status', 'uncomplete')->get()->map(function ($item) {
                    $item->source = 'task';
                    return $item;
                });

            $getInsuData = Staks::where('user_id', $userId)
                ->where('status', 'uncomplete') // Add the condition here
                ->get()
                ->map(function ($item) {
                    $item->source = 'stask';
                    return $item;
                });

        
        // Merge data from both tables into a new collection
        $mergedNotifications = $notificationsFromSession->merge($getInsuData);

        // Calculate notification count
        $notificationCount = $mergedNotifications->count();

        

        // Share data with all views
        view()->share('notificationsTask', $mergedNotifications);
        view()->share('notificationTaskCount', $notificationCount);
        view()->share('userId', $userId);
        return $next($request);
    }




   
}
