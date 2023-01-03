<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Order_Detail_Status;
use App\Order_Item;
use App\Orders;
use Illuminate\Http\Request;
use App\Product;
use App\Customer_Transport;
use App\Admin_Action_Order;
use App\Customer;
use App\Mail\Confirm_Order_Mail;
use App\Voucher;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PDF;

class OrderController extends Controller
{
    public function all_order(){
        $orders = Orders::orderBy('order_id', 'desc')->paginate(10);
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $payment_method = DB::table('payment_method')->get();
        $status_order = DB::table('status_order')->get();
        $wait_confirm = Order_Detail_Status::where('status',1)->where('status_id',1)->get();
        $confirmed = Order_Detail_Status::where('status',1)->where('status_id',2)->get();
        $delivering = Order_Detail_Status::where('status',1)->where('status_id',3)->get();
        $delivery_success = Order_Detail_Status::where('status',1)->where('status_id',4)->get();
        $cancelled = Order_Detail_Status::where('status',1)->where('status_id',5)->get();

        return view('admin.order.all_order',[
            'orders' => $orders,
            'order_detail_status' => $order_detail_status,
            'payment_method' => $payment_method,
            'status_order' => $status_order,
            'wait_confirm' => $wait_confirm,
            'confirmed' => $confirmed,
            'delivering' => $delivering,
            'delivery_success' => $delivery_success,
            'cancelled' => $cancelled,
        ]);
    }
    public function await_confirm_order(){
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->join('status_order','status_order.status_id','=','order_detail_status.status_id')
                ->where('status',1)->where('order_detail_status.status_id',1)->get();
        $payment_method = DB::table('payment_method')->get();
        return view('admin.order.await_confirm_order',[
            'orders'=>$orders,
            'payment_method'=>$payment_method
        ]);
    }
    public function confirm_order(Request $request){
        $order_code = $request->order_code;
        $order = Orders::where('order_code', $order_code)->first();
        $detail_status_id = Order_Detail_Status::where('status',1)->where('status_id',1)->where('order_id',$order->order_id)->first();

        $update_order_detail_status = Order_Detail_Status::where('detail_status_id',$detail_status_id->detail_status_id)->first();
        $update_order_detail_status->status = 0;
        $result_update = $update_order_detail_status->save();

        if($result_update){
            $add_order_detail_status = new Order_Detail_Status();
            $add_order_detail_status->order_id = $order->order_id;
            $add_order_detail_status->status_id = 2;
            $add_order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
            $add_order_detail_status->status = 1;
            $add_order_detail_status->save();
            //
            $action_order = new Admin_Action_Order();
            $action_order->admin_id = Session::get('admin_id');
            $action_order->order_id = $order->order_id;
            $action_order->action_id = 6;
            $action_order->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_order->action_message = 'Duyệt đơn hàng';
            $action_order->save();

            //send mail
            $customer = Customer::find($order->customer_id);
            $data=[
                'order' => $order,
            ];
            Mail::to($customer->email)->send(new Confirm_Order_Mail($data));

            $request->session()->flash('confirm_success', 'Xác nhận đơn hàng thành công');
            return redirect()->back();
        }
    }
    public function print_pdf_delivery_order($order_id){
        $order = Orders::find($order_id);
        // print pdf
        $trans = Customer_Transport::find($order->trans_id);
        $order_pdf = Orders::find($order_id);
        $order_item = DB::table('order_item')
                    ->join('product', 'product.product_id', '=','order_item.product_id')
                    ->where('order_id', $order->order_id)->get();
        $pdf = PDF::loadView('admin.order.view_print_pdf_delivery_order', [
            'order_pdf'=>$order_pdf,
            'order_item'=>$order_item,
            'trans'=>$trans,
        ]);
        return $pdf->download('pdf_giaohang.pdf');
    }
    public function confirmed(){
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->join('status_order','status_order.status_id','=','order_detail_status.status_id')
                ->where('status',1)->where('order_detail_status.status_id',2)->get();
        $payment_method = DB::table('payment_method')->get();
        return view('admin.order.confirmed_order',[
            'orders'=>$orders,
            'payment_method'=>$payment_method
        ]);
    }
    public function confirm_delivary_order(Request $request){
        $order_code = $request->order_code;
        $order = Orders::where('order_code', $order_code)->first();
        $detail_status_id = Order_Detail_Status::where('status',1)->where('status_id',2)->where('order_id',$order->order_id)->first();

        $update_order_detail_status = Order_Detail_Status::where('detail_status_id',$detail_status_id->detail_status_id)->first();
        $update_order_detail_status->status = 0;
        $result_update = $update_order_detail_status->save();

        if($result_update){
            $add_order_detail_status = new Order_Detail_Status();
            $add_order_detail_status->order_id = $order->order_id;
            $add_order_detail_status->status_id = 3;
            $add_order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
            $add_order_detail_status->status = 1;
            $add_order_detail_status->save();
            //
            $action_order = new Admin_Action_Order();
            $action_order->admin_id = Session::get('admin_id');
            $action_order->order_id = $order->order_id;
            $action_order->action_id = 6;
            $action_order->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_order->action_message = 'Duyệt giao đơn hàng';
            $action_order->save();

            $request->session()->flash('confirm_delivary_success', 'Xác nhận đơn hàng đang giao thành công');
            return redirect()->back();
        }
    }
    public function delivering(){
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->join('status_order','status_order.status_id','=','order_detail_status.status_id')
                ->where('status',1)->where('order_detail_status.status_id',3)->get();
        $payment_method = DB::table('payment_method')->get();
        return view('admin.order.delivering_order',[
            'orders'=>$orders,
            'payment_method'=>$payment_method
        ]);
    }
    public function confirm_delivery_success_order(Request $request){
        $order_code = $request->order_code;
        $order = Orders::where('order_code', $order_code)->first();
        $detail_status_id = Order_Detail_Status::where('status',1)->where('status_id',3)->where('order_id',$order->order_id)->first();

        $update_order_detail_status = Order_Detail_Status::where('detail_status_id',$detail_status_id->detail_status_id)->first();
        $update_order_detail_status->status = 0;
        $result_update = $update_order_detail_status->save();

        if($result_update){
            $add_order_detail_status = new Order_Detail_Status();
            $add_order_detail_status->order_id = $order->order_id;
            $add_order_detail_status->status_id = 4;
            $add_order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
            $add_order_detail_status->status = 1;
            $add_order_detail_status->save();

            $update_status_payment_order = Orders::find($order->order_id);
            $update_status_payment_order -> status_pay = 1;
            $update_status_payment_order -> save();

            //
            $action_order = new Admin_Action_Order();
            $action_order->admin_id = Session::get('admin_id');
            $action_order->order_id = $order->order_id;
            $action_order->action_id = 6;
            $action_order->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_order->action_message = 'Xác nhận giao hàng thành công';
            $action_order->save();

            //


            $request->session()->flash('confirm_delivary_success_order', 'Xác nhận giao đơn hàng thành công');
            return redirect()->back();
        }
    }
    public function delivery_success(){
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->join('status_order','status_order.status_id','=','order_detail_status.status_id')
                ->where('status',1)->where('order_detail_status.status_id',4)->orderBy('orders.order_id','desc')->get();
        $payment_method = DB::table('payment_method')->get();
        return view('admin.order.delivery_success',[
            'orders'=>$orders,
            'payment_method'=>$payment_method
        ]);
    }
    public function cancelled(){
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->join('status_order','status_order.status_id','=','order_detail_status.status_id')
                ->where('status',1)->where('order_detail_status.status_id',5)->get();
        $payment_method = DB::table('payment_method')->get();
        return view('admin.order.order_cancelled',[
            'orders'=>$orders,
            'payment_method'=>$payment_method
        ]);
    }
    public function search_order(Request $request){
        $search_order = $request->search_order;
        $result_find = Orders::where('order_code','LIKE','%'.$search_order.'%')
        ->orwhere('total_price','LIKE','%'.$search_order.'%')->get();

        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $payment_method = DB::table('payment_method')->get();
        $status_order = DB::table('status_order')->get();
        echo view('admin.order.view_search_order',[
            'orders'=>$result_find,
            'order_detail_status'=>$order_detail_status,
            'payment_method'=>$payment_method,
            'status_order'=>$status_order,
        ]);
    }
    public function detail_order_item(Request $request){
        $order_id = $request->order_id;
        $order_item = Order_Item::where('order_id', $order_id)->get();
        $product = Product::all();
        $order = Orders::find($order_id);
        $payment_method = DB::table('payment_method')->get();
        $status_order = DB::table('status_order')->get();
        $detail_status = Order_Detail_Status::where('order_id',$order_id)->where('status',1)->first();
        $transport = Customer_Transport::find($order->trans_id);
        $time_line = Order_Detail_Status::where('order_id', $order_id)->get();
        $all_voucher = Voucher::all();

        $admin_action_order = DB::table('admin_action_order')
                            ->join('admin','admin.admin_id','=','admin_action_order.admin_id')
                            ->where('admin_action_order.order_id', $order_id)
                            ->orderBy('admin_action_order.action_time','asc')
                            ->get();

        return view('admin.order.order_detail_item',[
            'order_item' =>$order_item,
            'product' =>$product,
            'order' =>$order,
            'payment_method' =>$payment_method,
            'status_order' =>$status_order,
            'detail_status' =>$detail_status,
            'trans' =>$transport,
            'time_line' =>$time_line,
            'all_voucher' =>$all_voucher,

            'admin_action_order' =>$admin_action_order,
        ]);
    }
    public function filter_order_fol_price(Request $request){
        $price_start = $request->price_start_order;
        $price_end = $request->price_end_order;
        $string_title = 'Danh Sách Đơn Hàng Giá Từ '.number_format($price_start, 0, ',', '.').'₫
                        đến '.number_format($price_end, 0, ',', '.').'₫';
        $payment_method = DB::table('payment_method')->get();
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        $type_filter = 'price';
        $level_filter = '';
        $price_filter_start = $price_start;
        $price_filter_end = $price_end;

        $all_order = Orders::whereBetween('total_price', [$price_start, $price_end])->get();
        echo view('admin.order.view_filter_order',[
            'orders'=>$all_order,
            'string_title'=>$string_title,
            'payment_method'=>$payment_method,
            'order_detail_status'=>$order_detail_status,
            'status_order'=>$status_order,

            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'price_filter_start'=>$price_filter_start,
            'price_filter_end'=>$price_filter_end,
        ]);

    }
    public function filter_order_fol_payment_status(Request $request){
        $payment_status = $request->status_pay;

        $type_filter = 'payment_status';
        $level_filter = $payment_status;


        $payment_method = DB::table('payment_method')->get();
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        if($payment_status == 1){
            $string_title = 'Danh Sách Đơn Hàng Đã Thanh Toán';
            $all_order = Orders::where('status_pay', 1)->get();
        }
        else{
            $string_title = 'Danh Sách Đơn Hàng Chưa Thanh Toán';
            $all_order = Orders::where('status_pay', 0)->get();
        }

        echo view('admin.order.view_filter_order',[
            'orders'=>$all_order,
            'string_title'=>$string_title,
            'payment_method'=>$payment_method,
            'order_detail_status'=>$order_detail_status,
            'status_order'=>$status_order,

            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);

    }
    public function filter_order_fol_payment_method(Request $request){
        $payment_method_pay = $request->payment_method;

        $type_filter = 'payment_method';
        $level_filter = $payment_method_pay;


        $payment_method = DB::table('payment_method')->get();
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        if($payment_method_pay == 0){
            $string_title = 'Danh Sách Đơn Hàng Thanh Toán Khi Nhận Hàng';
            $all_order = Orders::where('payment_id', 0)->get();
        }
        else{
            $string_title = 'Danh Sách Đơn Hàng Thanh Toán Bằng Paypal';
            $all_order = Orders::where('payment_id', 1)->get();
        }

        echo view('admin.order.view_filter_order',[
            'orders'=>$all_order,
            'string_title'=>$string_title,
            'payment_method'=>$payment_method,
            'order_detail_status'=>$order_detail_status,
            'status_order'=>$status_order,

            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);
    }
    public function filter_order_fol_date(Request $request){
        $date = $request->date;

        $type_filter = 'date';
        $level_filter = date('Y-m-d', strtotime($date));
        $string_title = 'Danh Sách Đơn Hàng ngày '.date('d/m/Y', strtotime($date));

        $payment_method = DB::table('payment_method')->get();
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        $all_order_get_date = Orders::all();
        $arrayProduct = array();
        foreach ($all_order_get_date as $getOrder){
            $date_create = date('Y-m-d', strtotime($getOrder->create_at));
            if($level_filter == $date_create){
                $arrayProduct[] = $getOrder;
            }
        }
        $all_order = $arrayProduct;

        echo view('admin.order.view_filter_order',[
            'orders'=>$all_order,
            'string_title'=>$string_title,
            'payment_method'=>$payment_method,
            'order_detail_status'=>$order_detail_status,
            'status_order'=>$status_order,

            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);
    }
    public function filter_order_fol_date_many(Request $request){
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $date_filter_start = date('Y-m-d', strtotime($date_start));
        $date_filter_end = date('Y-m-d', strtotime($date_end));

        $type_filter = 'date_many';
        $level_filter = '';
        $start_date = $date_filter_start;
        $end_date = $date_filter_end;

        $payment_method = DB::table('payment_method')->get();
        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        $string_title = 'Danh Sách Đơn Hàng Từ Ngày '.date('d/m/Y', strtotime($date_start)).'
                        Đến Ngày '.date('d/m/Y', strtotime($date_filter_end)).'';
        $arrayProduct = array();
        $all_order_get_date = Orders::all();
        foreach ($all_order_get_date as $getOrder){
            $date_create = date('Y-m-d', strtotime($getOrder->create_at));
            if($start_date <= $date_create && $date_create <= $end_date){
                $arrayProduct[] = $getOrder;
            }
        }
        $all_order = $arrayProduct;

        echo view('admin.order.view_filter_order',[
            'orders'=>$all_order,
            'string_title'=>$string_title,
            'payment_method'=>$payment_method,
            'order_detail_status'=>$order_detail_status,
            'status_order'=>$status_order,

            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
        ]);
    }

    public function print_pdf_order(Request $request){
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;

        $order_detail_status = Order_Detail_Status::where('status',1)->get();
        $status_order = DB::table('status_order')->get();

        switch ($type_filter) {
            case "price":
                    $price_start = $request->price_filter_start;
                    $price_end = $request->price_filter_end;
                    $string_title = 'Danh Sách Đơn Hàng Theo Giá " Từ '.number_format($price_start,0,',','.')
                                    .'₫ Đến '.number_format($price_end,0,',','.').'₫ "';

                    $all_order = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->whereBetween('total_price',[$price_start, $price_end])->get();

                    $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                        'all_order'=>$all_order,
                        'string_title'=>$string_title,
                        'order_detail_status'=>$order_detail_status,
                        'status_order'=>$status_order,
                    ]);
                    return $pdf->download('List_order_filter_price.pdf');
                break;
            case "payment_status":
                    if($level_filter == 1){
                        $string_title = 'Danh Sách Đơn Hàng Đã Thanh Toán';
                        $all_order = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->where('status_pay', 1)->get();

                    }
                    else{
                        $string_title = 'Danh Sách Đơn Hàng Chưa Thanh Toán';
                        $all_order = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->where('status_pay', 0)->get();
                    }
                    $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                        'all_order'=>$all_order,
                        'string_title'=>$string_title,
                        'order_detail_status'=>$order_detail_status,
                        'status_order'=>$status_order,
                    ]);
                    return $pdf->download('List_order_filter_payment_status.pdf');
                break;
            case "payment_method":
                    if($level_filter == 0){
                        $string_title = 'Danh Sách Đơn Hàng Thanh Toán Khi Nhận Hàng';
                        $all_order = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->where('orders.payment_id', 0)->get();
                    }
                    else{
                        $string_title = 'Danh Sách Đơn Hàng Thanh Toán Bằng Paypal';
                        $all_order = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->where('orders.payment_id', 1)->get();
                    }
                    $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                        'all_order'=>$all_order,
                        'string_title'=>$string_title,
                        'order_detail_status'=>$order_detail_status,
                        'status_order'=>$status_order,
                    ]);
                    return $pdf->download('List_order_filter_payment_method.pdf');
                break;
            case "date":
                    $string_title = 'Danh Sách Đơn Hàng ngày '.date('d/m/Y', strtotime($level_filter));

                    $all_order_get_date = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->get();
                    $arrayProduct = array();
                    foreach ($all_order_get_date as $getOrder){
                        $date_create = date('Y-m-d', strtotime($getOrder->create_at));
                        if($level_filter == $date_create){
                            $arrayProduct[] = $getOrder;
                        }
                    }
                    $all_order = $arrayProduct;
                    $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                        'all_order'=>$all_order,
                        'string_title'=>$string_title,
                        'order_detail_status'=>$order_detail_status,
                        'status_order'=>$status_order,
                    ]);
                    return $pdf->download('List_order_filter_date.pdf');
                break;
            case "date_many":
                    $start_date = $request->start_date;
                    $end_date = $request->end_date;

                    $string_title = 'Danh Sách Đơn Hàng Từ Ngày '.date('d/m/Y', strtotime($start_date)).'
                                Đến Ngày '.date('d/m/Y', strtotime($end_date)).'';
                    $all_order_get_date = DB::table('orders')
                                ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                                ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                                ->get();
                    $arrayProduct = array();
                    foreach ($all_order_get_date as $getOrder){
                        $date_create = date('Y-m-d', strtotime($getOrder->create_at));
                        if($start_date <= $date_create && $date_create <= $end_date){
                            $arrayProduct[] = $getOrder;
                        }
                    }
                    $all_order = $arrayProduct;
                    $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                        'all_order'=>$all_order,
                        'string_title'=>$string_title,
                        'order_detail_status'=>$order_detail_status,
                        'status_order'=>$status_order,
                    ]);
                    return $pdf->download('List_order_filter_date_many.pdf');
                break;
            default:
                $string_title = 'Danh Sách Đơn Hàng';
                $all_order = DB::table('orders')
                        ->join('customer_transport','customer_transport.trans_id','=','orders.trans_id')
                        ->join('payment_method','payment_method.payment_id','=','orders.payment_id')
                        ->get();
                $order_detail_status = Order_Detail_Status::where('status',1)->get();
                $status_order = DB::table('status_order')->get();

                $pdf = PDF::loadView('admin.order.view_print_pdf_order', [
                    'all_order'=>$all_order,
                    'string_title'=>$string_title,
                    'order_detail_status'=>$order_detail_status,
                    'status_order'=>$status_order,
                ]);
                return $pdf->download('danhsachdonhang.pdf');
        }
    }
}
