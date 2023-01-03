<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PermissionDelivery
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
        if (Auth::check()) {
            if (Auth::user()->hasRole('delivery')) {
                return $next($request);
            } else {
                return redirect('login_shipper');
            }
        } else {
            return redirect('login_shipper');
        }
    }
}
