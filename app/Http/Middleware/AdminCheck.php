<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminCheck
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
        try {
            if(Auth::user()->role == User::ADMIN_ROLE) {
                return $next($request);
            } else{
                throw new Exception('Unauthorized Access');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
