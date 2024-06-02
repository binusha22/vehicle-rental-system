<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\User;

class Admin
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
      // Check if any user is logged in
      if ($request->session()->has('loginId')) {
        // Check if the logged-in user is an admin with the correct type
        $user = User::where('id', '=', $request->session()->get('loginId'))->first();

        if ($user && $user->type === 'admin') {
            return $next($request);
        } else {
            return redirect()->back()->with('f','Unauthorized access.');
        }
    }

    // If no user is logged in, redirect to login
    return redirect('/login')->with('f', 'You need to log in first.');
}}