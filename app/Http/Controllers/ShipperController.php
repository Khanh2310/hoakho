<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\Admin_Action_Order;
use App\Admin_Roles;
use App\Customer_Transport;
use App\Order_Detail_Status;
use App\Order_Item;
use App\Orders;
use App\Product;
use App\Roles;
use App\User;
use App\Voucher;
use Carbon\Carbon;
use DB;
use Session;

class ShipperController extends Controller
{
    //
    public function show_login()
    {
        return view('shipper.login_shipper');
    }
    public function all_order_delivering()
    {
        $all_order_delivered = DB::table('orders')
            ->join('order_detail_status', 'order_detail_status.order_id', '=', 'orders.order_id')
            ->where('status_id', 3)
            ->where('status', 1)
            ->get();
        $transport = Customer_Transport::all();
        return view('shipper.all_order_delivering', compact('all_order_delivered', 'transport'));
    }
    public function order_detail($order_id)
    {
        $order = Orders::where('order_id', $order_id)->first();
        $order_items = Order_Item::where('order_id', $order_id)->get();
        $customer_id = $order->customer_id;
        $trans_id = $order->trans_id;
        $trans = Customer_Transport::where('trans_id', $trans_id)->first();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();

        return view('shipper.order_detail', compact(
            'order',
            'order_items',
            'trans',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'all_voucher'
        ));
    }
    public function confirm_delivery_order_success(Request $request)
    {
        $order_code = $request->order_code;
        $order = Orders::where('order_code', $order_code)->first();
        $detail_status_id = Order_Detail_Status::where('status', 1)->where('status_id', 3)->where('order_id', $order->order_id)->first();

        $update_order_detail_status = Order_Detail_Status::where('detail_status_id', $detail_status_id->detail_status_id)->first();
        $update_order_detail_status->status = 0;
        $result_update = $update_order_detail_status->save();

        if ($result_update) {
            $add_order_detail_status = new Order_Detail_Status();
            $add_order_detail_status->order_id = $order->order_id;
            $add_order_detail_status->status_id = 4;
            $add_order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
            $add_order_detail_status->status = 1;
            $add_order_detail_status->save();

            $update_status_payment_order = Orders::find($order->order_id);
            $update_status_payment_order->status_pay = 1;
            $update_status_payment_order->save();

            //
            $action_order = new Admin_Action_Order();
            $action_order->admin_id = Session::get('admin_id');
            $action_order->order_id = $order->order_id;
            $action_order->action_id = 6;
            $action_order->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_order->action_message = 'Xác nhận giao hàng thành công';
            $action_order->save();

            $string_message = 'Đã xác nhận giao đơn hàng thành công #' . $order_code;
            $request->session()->flash('confirm_delivery_order_success', $string_message);
            return redirect('/delivering');
        }
    }
    public function confirm_delivery_order_fail(Request $request)
    {
        $order_code = $request->order_code;
        $order = Orders::where('order_code', $order_code)->first();
        $detail_status_id = Order_Detail_Status::where('status', 1)->where('status_id', 3)->where('order_id', $order->order_id)->first();

        $update_order_detail_status = Order_Detail_Status::where('detail_status_id', $detail_status_id->detail_status_id)->first();
        $update_order_detail_status->status = 0;
        $result_update = $update_order_detail_status->save();

        if ($result_update) {
            $add_order_detail_status = new Order_Detail_Status();
            $add_order_detail_status->order_id = $order->order_id;
            $add_order_detail_status->status_id = 5;
            $add_order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
            $add_order_detail_status->status = 1;
            $add_order_detail_status->save();

            //
            $action_order = new Admin_Action_Order();
            $action_order->admin_id = Session::get('admin_id');
            $action_order->order_id = $order->order_id;
            $action_order->action_id = 6;
            $action_order->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_order->action_message = 'Xác nhận giao hàng không thành công';
            $action_order->save();

            $string_message = 'Đã xác nhận giao đơn hàng không thành công #' . $order_code;
            $request->session()->flash('confirm_delivery_order_success', $string_message);
            return redirect('/delivering');
        }
    }
    public function process_login(Request $request)
    {
        $admin_login = Admin::where('admin_email', $request->email)->where('password', md5($request->password))->first();
        if ($admin_login) {
            $roles = Admin_Roles::where('admin_admin_id', $admin_login->admin_id)->where('roles_roles_id', 4)->first();
            if ($roles) {
                Auth::login($admin_login);
                Session::put('admin_id', $admin_login->admin_id);
                Session::put('admin_name', $admin_login->admin_name);
                Session::put('admin_image', $admin_login->avt);
                return redirect('/delivering');
            } else {
                return redirect('login_shipper')->withErrors('Đăng Nhập Thất Bại');
            }
        } else {
            return redirect('login_shipper')->withErrors('Đăng Nhập Thất Bại');
        }
    }
    public function logout_shipper()
    {
        Auth::logout();
        Session::forget('admin_id');
        Session::forget('admin_name');
        Session::forget('admin_image');
        return redirect('login_shipper');
    }
}
