<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //return redirect('/home');
            $role = Auth::user()->role;
            //error_log(User::ADMIN_ROLE);
            if ($role == 0) {
                return redirect('/admin/home');
            } else {
                return redirect('/employee/home');
            }
        }

        return $next($request);
    }
}
