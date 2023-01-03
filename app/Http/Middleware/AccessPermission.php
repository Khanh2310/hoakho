<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Auth;

class AccessPermission
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->hasAnyRoles(['admin', 'manager', 'employee', 'delivery'])) {
                return $next($request);
            } else {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }
}
