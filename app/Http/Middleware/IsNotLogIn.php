<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsNotLogIn
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
        if (!$request->session()->has('loginId')) {
            if ($request->is('logout')) {
                if (!$request->session()->has('loginId')){
                return redirect('/login')->with('f', 'You need to log in first to log out.');
                }
            }
            return redirect('/login')->with('f', 'You need to log in first');
        }
        return $next($request);
    }
}
