<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class PermissionAdmin_Manager_Employee
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
        if(Auth::check()){
            if(Auth::user()->hasAnyRoles(['admin','manager','employee'])){
                return $next($request);
            }
            else{
                $request->session()->flash('no_permission', 'Bạn không có quyền truy cập trang này');
                return redirect('admin/');
            }
        }
        else{
            return redirect('login');
        }
    }
}
