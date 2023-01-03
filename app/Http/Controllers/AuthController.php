<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Admin;
use App\Admin_Roles;
use App\Roles;
use App\User;
use Session;

Session::start();
class AuthController extends Controller
{
    public function show_login()
    {
        return view('admin.login.login_admin');
    }
    public function process_login(Request $request)
    {
        $admin_login = Admin::where('admin_email', $request->email)->where('password', md5($request->password))->first();
        if ($admin_login) {
            Auth::login($admin_login);
            Session::put('admin_id', $admin_login->admin_id);
            Session::put('admin_name', $admin_login->admin_name);
            Session::put('admin_image', $admin_login->avt);

            if (Auth::user()->hasAnyRoles(['admin', 'manager', 'employee'])) {
                return redirect('admin/');
            } else {
                return redirect('login')->withErrors('Bạn không có quyền truy cập');
            }
        } else {
            return redirect('login')->withErrors('Đăng Nhập Thất Bại');
        }
    }
    public function logout_admin()
    {
        Auth::logout();
        Session::forget('admin_id');
        Session::forget('admin_name');
        Session::forget('admin_image');
        return redirect('login');
    }
}
