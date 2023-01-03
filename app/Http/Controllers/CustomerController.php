<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Customer_Info;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword as MailResetPassword;
use App\Mail\VerifyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

Session::start();
class CustomerController extends Controller
{
    //

    public static function image($customer_id)
    {
        $customer = Customer_Info::where('customer_id', $customer_id)->first();
        $image = $customer->customer_avt;
        return $image;
    }

    public function show_login()
    {
        return view('client.login.login_client');
    }

    public function process_login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Bạn chưa nhập Email',
            'password.required' => 'Bạn chưa nhập Mật khẩu',
        ]);
        $check_customer_login = Customer::where('email', $request->email)->where('password', md5(md5($request->password)))->first();

        if ($check_customer_login) {
            $customer = Customer_Info::where('customer_id', $check_customer_login->customer_id)->first();
            if ($customer->customer_avt != '') {
                $customer_avt = $customer->customer_avt;
            } else {
                $customer_avt = 'user.png';
            }

            Session::put('customer_id', $check_customer_login->customer_id);
            Session::put('username', $check_customer_login->username);
            return redirect('/');
        } else {
            return redirect('login_client')->withErrors('Email hoặc mật khẩu không đúng');
        }
    }

    public function show_register()
    {
        return view('client.login.register_client');
    }

    public function process_register($username, $email, $password)
    {

        $check_email_register = Customer::where('email', $email)->get();

        if (count($check_email_register) > 0) {
            return redirect('error_process_register');
        } else {
            $customer_register = new Customer();
            $customer_register->username = $username;
            $customer_register->email = $email;
            $customer_register->password = md5($password);
            $customer_register->save();

            $customer_info = new Customer_Info();
            $customer_info->customer_id = $customer_register->customer_id;
            $customer_info->customer_fullname = '';
            $customer_info->customer_phone = '';
            $customer_info->customer_avt = 'user.png';
            $customer_info->customer_gender = '';
            $customer_info->customer_birthday = '2000-01-01';
            $customer_info->save();

            return redirect('success_process_register');
        }
    }

    public function mail_reset_password()
    {
        return view('client.login.mail_reset_password');
    }

    public function process_mail_reset_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
        ]);
        $customer = Customer::where('email', $request->email)->first();
        if (isset($customer)) {
            $customer_id = $customer->customer_id;
            $data = [
                'customer_id' => $customer_id,
            ];

            Mail::to($request->email)->send(new MailResetPassword($data));
            return redirect('login_client');
        } else {
            return redirect('mail_reset_password')->withErrors('Email không tồn tại trong hệ thống');
        }
    }

    public function reset_password($customer_id)
    {
        return view('client.login.reset_password', compact('customer_id'));
    }

    public function process_reset_password(Request $request, $customer_id)
    {
        $this->validate($request, [
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có độ dài tối thiểu 8 ký tự',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống',
            'password_confirmation.same' => 'Mật khẩu không khớp',
        ]);
        $customer = Customer::find($customer_id);
        $customer->password = md5(md5($request->password));
        $customer->save();
        return redirect('login_client');
    }

    public function mail_register_client(Request $request)
    {
        $check_email_register = Customer::where('email', $request->email)->get();

        if (count($check_email_register) > 0) {
            return redirect('register_client')->withErrors('Email Đã tồn tại');
        } else {
            $this->validate($request, [
                'username' => 'required',
                'email' => 'required|email|min:3|max:100',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ], [
                'username.required' => 'Tên người dùng không được để trống',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.min' => 'Email phải có độ dài tối thiểu 3 ký tự',
                'email.max' => 'Email phải có độ dài tối đa 100 ký tự',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có độ dài tối thiểu 8 ký tự',
                'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống',
                'password_confirmation.same' => 'Mật khẩu không khớp',
            ]);

            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => md5($request->password),
            ];

            Mail::to($request->email)->send(new VerifyAccount($data));
            return redirect('verify_account');
        }
    }

    public function verify_account()
    {
        return view('client.login.verify_account');
    }

    public function success_process_register()
    {
        return view('client.login.success_process_register');
    }

    public function error_process_register()
    {
        return view('client.login.error_process_register');
    }

    public function logout_client()
    {

        Session::forget('customer_id');
        Session::forget('username');
        Session::flush();

        return redirect('login_client');
    }
}
