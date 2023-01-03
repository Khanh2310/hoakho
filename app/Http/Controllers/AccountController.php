<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Customer_Info;
use App\Customer_Transport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Cart;
use App\Order_Detail_Status;
use App\Order_Item;
use App\Orders;
use App\Product;
use App\ProductPrice;
use App\Storage_Customer_Voucher;
use App\Storage_Product;
use App\Voucher;
use App\WishList;
class AccountController extends Controller
{
    function check_login(){
        $session = Session::get('customer_id');
        if($session == "" || $session == null){
            return redirect('login_client')->send();
        }
    }
    //
    public function show_account(){
        $this->check_login();
        $customer_id = Session::get('customer_id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        return view('client.user.account',
            compact('customer_info', 'customer', 'all_product', 'all_cart', 'all_price','wish_lish'));
    }

    public function update_account(Request $request){

        // echo $request->fd;

        $customer_fullname = $request->customer_fullname;
        $customer_phone = $request->customer_phone;
        $customer_gender = $request->customer_gender;
        $customer_birthday = $request->customer_birthday;

        $year_now = Carbon::now()->year;
        $input_year = date('Y', strtotime($request->customer_birthday));
        $check_year = $year_now - $input_year;

        $avt = $request->customer_avt;
        if($customer_fullname == ''){
            echo 1;
        }
        else if($customer_phone == ''){
            echo 2;
        }
        else if(strlen($customer_phone) < 10 || strlen($customer_phone) > 10){
            echo 3;
        }
        else if($customer_phone[0] != 0){
            echo 4;
        }
        else if($input_year > $year_now){
            echo 5;
        }
        else if($check_year <= 12){
            echo 6;
        }
        else{
            $customer_id = Session::get('customer_id');
            $customer_info = Customer_Info::where('customer_id', $customer_id)->first();

            $customer_info->customer_fullname = $customer_fullname;
            $customer_info->customer_phone = $customer_phone;
            $customer_info->customer_gender = $customer_gender;
            $customer_info->customer_birthday = $customer_birthday;
            $get_image = $request->file('customer_avt');
            if(isset($get_image)){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('public/upload',$new_image);
                $customer_info->customer_avt = $new_image;
            }
            $customer_info->save();
            echo 7;
        }
    }
    public function upload_avt_account(Request $request){
        $customer_id = Session::get('customer_id');
        if($request->hasFile('customer_avt')){
            $get_image = $request->file('customer_avt');
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload',$new_image);

            $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
            $customer_info->customer_avt = $new_image;
            $customer_info->save();
        }
    }

    public function address_account(){
        $customer_id = Session::get('customer_id');

        $all_address = Customer_Transport::where('customer_id', $customer_id)->get();

        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $citys = DB::table('tinhthanhpho')->get();
        $districts = DB::table('quanhuyen')->get();
        $wards = DB::table('xaphuongthitran')->get();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        return view('client.user.address',
            compact('customer_info', 'customer', 'all_address', 'citys', 'districts', 'wards', 'all_product', 'all_cart', 'all_price','wish_lish'));
    }

    public function process_add_address(Request $request){

        $name = $request->fullname;
        $phone = $request->phone;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $detail_address = $request->detail_address;

        $customer_id = Session::get('customer_id');
        $name_city = DB::table('tinhthanhpho')->where('matp', $city)->first();
        $name_district = DB::table('quanhuyen')->where('maqh', $district)->first();
        $name_ward = DB::table('xaphuongthitran')->where('xaid', $ward)->first();
        //address
        $trans_address = $detail_address.", ".$name_ward->name_xa.", ".$name_district->name_qh.", ".$name_city->name_tp;

        $transport = new Customer_Transport();
        $transport->customer_id = $customer_id;
        $transport->trans_fullname = $name;
        $transport->trans_phone = $phone;
        $transport->trans_address = $trans_address;
        $all_transport = Customer_Transport::where('customer_id', $customer_id)->get();
        if(count($all_transport) == 0){
            $transport->trans_status = 1;
        }
        else{
            $transport->trans_status = 0;
        }
        $transport->save();
}

    public function get_id_trans(Request $request){
        $trans_id = $request->trans_id;
        $transport = Customer_Transport::find($trans_id);
        echo $transport->trans_fullname;
    }
    public function get_phone_trans(Request $request){
        $trans_id = $request->trans_id;
        $transport = Customer_Transport::find($trans_id);
        echo $transport->trans_phone;
    }
    public function get_address_detail_trans(Request $request){
        $trans_id = $request->trans_id;
        $trans_address = Customer_Transport::find($trans_id);

        $address_detail = explode(", ", $trans_address->trans_address, -3);
        $count_trans_address_old = count($address_detail);
        $array_address_detail = '';
        for($i = 0; $i < $count_trans_address_old; $i++){
            $array_address_detail = $array_address_detail.', '.$address_detail[$i];
        }
        echo trim($array_address_detail,', ');
    }
    public function get_address_ward_trans(Request $request){
        $trans_id = $request->trans_id;
        $trans_address = Customer_Transport::find($trans_id);


        $address_ward = explode(", ", $trans_address->trans_address);
        $count_trans_address_old = count($address_ward);
        echo $address_ward[$count_trans_address_old - 3];
    }
    public function get_address_district_trans(Request $request){
        $trans_id = $request->trans_id;
        $trans_address = Customer_Transport::find($trans_id);


        $address_district = explode(", ", $trans_address->trans_address);
        $count_trans_address_old = count($address_district);
        echo $address_district[$count_trans_address_old - 2];
    }
    public function get_address_city_trans(Request $request){
        $trans_id = $request->trans_id;
        $trans_address = Customer_Transport::find($trans_id);


        $address_city = explode(", ", $trans_address->trans_address);
        $count_trans_address_old = count($address_city);
        echo $address_city[$count_trans_address_old - 1];
    }

    public function process_update_address(Request $request){

        $trans_id = $request->trans_id;
        $name = $request->fullname;
        $phone = $request->phone;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $detail_address = $request->detail_address;

        if($name == ''){
            echo 1;
        }
        else if($phone == ''){
            echo 2;
        }
        else if(strlen($phone) < 10 || strlen($phone) > 10){
            echo 3;
        }
        else if($phone[0] != 0){
            echo 4;
        }
        else if($detail_address == ''){
            echo 5;
        }
        else{
            if($city == '' && $district == '' && $ward == ''){
                $customer_transport = Customer_Transport::where('trans_id', $trans_id)->first();
                $trans_address = $customer_transport->trans_address;
                $trans_address_old = explode(", ", $trans_address);
                $count_trans_address_old = count($trans_address_old);
                $trans_address_explode = $trans_address_old[$count_trans_address_old - 3].', '.$trans_address_old[$count_trans_address_old - 2].', '.$trans_address_old[$count_trans_address_old - 1];
                $trans_address_new = rtrim($detail_address, '.').', '.$trans_address_explode;

                $customer_transport->trans_fullname = $name;
                $customer_transport->trans_phone = $phone;
                $customer_transport->trans_address = $trans_address_new;
                $customer_transport->save();

                echo 6;

            }
            else{
                if($city != '' && $district == '' && $ward == ''){
                    echo 7;
                }
                else if($city != '' && $district != '' && $ward == ''){
                    echo 8;
                }
                else if($city != '' && $district != '' && $ward != ''){
                    $name_city = DB::table('tinhthanhpho')->where('matp', $city)->first();
                    $name_district = DB::table('quanhuyen')->where('maqh', $district)->first();
                    $name_ward = DB::table('xaphuongthitran')->where('xaid', $ward)->first();

                    $trans_address = $detail_address.", ".$name_ward->name_xa.", ".$name_district->name_qh.", ".$name_city->name_tp;

                    $transport = Customer_Transport::where('trans_id', $trans_id)->first();
                    $transport->trans_fullname = $name;
                    $transport->trans_phone = $phone;
                    $transport->trans_address = $trans_address;
                    $transport->save();

                    echo 9;
                }
            }
        }
    }

    public function process_delete_address(Request $request){
        $trans_id = $request->trans_id;
        Customer_Transport::destroy($trans_id);
    }

    public function process_mode_default(Request $request){
        $customer_id = Session::get('customer_id');
        $transport_disable_status = Customer_Transport::where('customer_id', $customer_id)->where('trans_status', '=', 1)->first();
        $transport_disable_status->trans_status = 0;
        $transport_disable_status->save();

        $transport_default_status = Customer_Transport::where('trans_id', $request->trans_id)->first();
        $transport_default_status->trans_status = 1;
        $transport_default_status->save();
        return redirect()->back();

    }

    public function reset_password_account(){
        $customer_id = Session::get('customer_id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        return view('client.user.resetpassword', compact('customer_info', 'customer', 'all_product', 'all_cart', 'all_price','wish_lish'));
    }

    public function process_update_password(Request $request){

        $password_old = $request->password_old;
        $password_new = $request->password_new;
        $password_new_confirmation = $request->password_new_confirmation;

        $customer_id = Session::get('customer_id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_password = $customer->password;

        if($password_old == ''){
            echo 1;
        }
        else if(md5(md5($password_old)) != $customer_password){
            echo 2;
        }
        else{
            if($password_new == ''){
                echo 3;
            }
            else if(strlen($password_new) < 8){
                echo 4;
            }
            else if($password_new_confirmation == ''){
                echo 5;
            }
            else if($password_new_confirmation != $password_new){
                echo 6;
            }
            else{
                $customer->password = md5(md5($password_new));
                $customer->save();
                echo 7;
            }
        }
    }

    public function order_account(){
        $customer_id = Session::get('customer_id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        $all_order = Orders::where('customer_id', $customer_id)->orderBy('order_id','desc')->get();
        $all_order_item = Order_Item::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();

        // $status_order_confirm = Order_Detail_Status::where('status_id', 1)->where('status',1)->get();
        $order_confirm = DB::table('order_detail_status')
        ->join('orders','orders.order_id','=','order_detail_status.order_id')
        ->where('orders.customer_id', $customer_id)
        ->where('status',1)
        ->where('order_detail_status.status_id',1)->get();

        // $status_order_confirmed = Order_Detail_Status::where('status_id', 2)->where('status',1)->get();
        $order_confirmed = DB::table('order_detail_status')
        ->join('orders','orders.order_id','=','order_detail_status.order_id')
        ->where('orders.customer_id', $customer_id)
        ->where('status',1)
        ->where('order_detail_status.status_id',2)->get();

        // $status_order_delivering = Order_Detail_Status::where('status_id', 3)->where('status',1)->get();
        $order_delivering = DB::table('order_detail_status')
        ->join('orders','orders.order_id','=','order_detail_status.order_id')
        ->where('orders.customer_id', $customer_id)
        ->where('status',1)
        ->where('order_detail_status.status_id',3)->get();

        // $status_order_delivered = Order_Detail_Status::where('status_id', 4)->where('status',1)->get();
        $order_delivered = DB::table('order_detail_status')
        ->join('orders','orders.order_id','=','order_detail_status.order_id')
        ->where('orders.customer_id', $customer_id)
        ->where('status',1)
        ->where('order_detail_status.status_id',4)->get();

        // $status_order_cancelled = Order_Detail_Status::where('status_id', 5)->where('status',1)->get();
        $order_cancelled = DB::table('order_detail_status')
        ->join('orders','orders.order_id','=','order_detail_status.order_id')
        ->where('orders.customer_id', $customer_id)
        ->where('status',1)
        ->where('order_detail_status.status_id',5)->get();

        return view('client.user.order', compact('customer_info', 'customer', 'all_product', 'all_cart',
         'all_price', 'all_order', 'all_order_item', 'all_order_detail_status', 'status_order',
        'order_confirm', 'order_confirmed', 'order_delivering', 'order_delivered', 'order_cancelled','wish_lish'));
    }

    public function order_detail_account($order_id){
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $order = Orders::where('order_id', $order_id)->first();
        $all_order_item = Order_Item::all();
        $all_order_detail_status = Order_Detail_Status::orderBy('time_status', 'desc')->get();
        $status_order = DB::table('status_order')->get();
        $payment_method = DB::table('payment_method')->get();
        $trans_address = Customer_Transport::all();
        return view('client.user.order_detail', compact('customer', 'customer_info', 'all_cart',
         'all_product', 'all_price', 'order', 'all_order_item', 'all_order_detail_status', 'status_order', 'payment_method', 'trans_address','wish_lish'));
    }

    public function process_cancel_order(Request $request){
        $order_id = $request->order_id;
        $order_detail_status = Order_Detail_Status::where('order_id', $order_id)->where('status', 1)->first();
        $order_item = Order_Item::where('order_id', $order_id)->get();
        foreach($order_item as $item){
            $product_id = $item->product_id;
            $quantity_item = $item->quantity_product;
            $quantity_storage_product = Storage_Product::where('product_id', $product_id)->first();
            $quantity_product = $quantity_storage_product->total_quantity_product;
            $quantity_storage_product->total_quantity_product =  $quantity_item + $quantity_product;
            $quantity_storage_product->save();
            // echo $product_id.'--- Số lượng sản phẩm/item ---'.$quantity_item.'-- Trước khi đổi ---'.$quantity_product.'-- Sau khi thay đổi --'.$quantity_storage_product->total_quantity_product.'<br>';
        }
        $order_detail_status->status_id = 5;
        $order_detail_status->save();
    }

    public function show_voucher(){
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $storage_customer_voucher = DB::table('storage_customer_voucher')
                                        ->join('voucher', 'voucher.voucher_id', '=', 'storage_customer_voucher.voucher_id')
                                        ->where('voucher.status', 1)
                                        ->where('voucher.start_date', '<=' , $date_now)
                                        ->where('voucher.end_date', '>=', $date_now)
                                        ->where('storage_customer_voucher.status', 1)
                                        ->where('customer_id', $customer_id)->get();
        return view('client.user.storage_customer_voucher', compact('customer', 'customer_info','storage_customer_voucher',
        'all_cart', 'all_product', 'all_price','wish_lish'));
    }
}
