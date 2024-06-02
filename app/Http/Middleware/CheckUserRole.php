<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role  // This is the role parameter passed from the route definition
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
{
    // Check if any user is logged in
    if ($request->session()->has('loginId')) {
        // Check if the logged-in user exists and has the correct type
        $user = User::find($request->session()->get('loginId'));

        if ($user && ($user->type === 'admin' || $user->type === 'manegment')) {
            return $next($request);
        } else {
            return redirect()->back()->with('f', 'Unauthorized access.'); // Adjust the error message as needed
        }
    }

    // If no user is logged in, redirect to login
    return redirect('/login')->with('f', 'You need to log in first.');
}

}
