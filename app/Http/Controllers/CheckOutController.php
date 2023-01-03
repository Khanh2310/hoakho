<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\ProductPrice;
use App\Orders;
use App\Order_Item;
use App\Order_Detail_Status;
use App\Storage_Product;
use DB;
use App\Customer_Transport;
use App\Storage_Customer_Voucher;
use App\Voucher;
use App\Shipping_Cost;
use Session;
use Carbon\Carbon;

Session::start();
class CheckOutController extends Controller
{

    public function show_checkout(Request $request){
        $arrCart_id = $request->itemCart;
        $all_cart = Cart::where('status', 1)->get();
        $all_product = Product::all();
        $product_price = ProductPrice::where('status',1)->get();
        $citys = DB::table('tinhthanhpho')->get();
        $fee_ship = 0;

        $customer_id = Session::get('customer_id');
        $static_trans = Customer_Transport::where('trans_status', 1)->where('customer_id',$customer_id)->first();
        $cus_trans = Customer_Transport::where('customer_id',$customer_id)->get();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $storage_customer_voucher = DB::table('storage_customer_voucher')
                                ->join('voucher', 'voucher.voucher_id', '=', 'storage_customer_voucher.voucher_id')
                                ->where('storage_customer_voucher.status', 1)
                                ->where('voucher.start_date', '<=' , $date_now)
                                 ->where('voucher.end_date', '>=', $date_now)
                                ->where('storage_customer_voucher.customer_id', $customer_id)
                                ->get();
        if($static_trans){
            $address = $static_trans->trans_address;
            $arrCity = explode(", ", $address);
            $city = $arrCity[count($arrCity)-1];
            $distance = Shipping_Cost::where('end_position', $city)->first();
            if($distance){
                $fee_ship = $distance->cost;
            }
        }

        return view('client.checkout.checkout',[
            'arrCart_id' => $arrCart_id,
            'all_cart' => $all_cart,
            'all_product' => $all_product,
            'product_price' => $product_price,
            'citys' => $citys,
            'static_trans' =>$static_trans,
            'cus_trans' =>$cus_trans,
            'storage_customer_voucher' => $storage_customer_voucher,
            'fee_ship' => $fee_ship,
        ]);
    }
    public function get_fee_ship_checkout(Request $request){
        $trans_id = $request->trans_id;
        $trans = Customer_Transport::find($trans_id);
        $fee_ship = 0;
        if($trans){
            $address = $trans->trans_address;
            $arrCity = explode(", ", $address);
            $city = $arrCity[count($arrCity)-1];
            $distance = Shipping_Cost::where('end_position', $city)->first();
            if($distance){
                $fee_ship = $distance->cost;
            }
        }
        echo $fee_ship;
    }
    public function add_address_trans(Request $request){

        $name = $request->fullname;
        $phone = $request->phone;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $detail_address = $request->detail_address;

        $find_city = DB::table('tinhthanhpho')->where('matp',$city)->first();
        $txt_city = $find_city->name_tp;
        $find_district = DB::table('quanhuyen')->where('maqh',$district)->first();
        $txt_district = $find_district->name_qh;
        $find_ward = DB::table('xaphuongthitran')->where('xaid',$ward)->first();
        $txt_ward = $find_ward->name_xa;

        $address_trans = $detail_address.', '.$txt_ward.', '.$txt_district.', '.$txt_city;
        $customer_id = Session::get('customer_id');
        $find_static = Customer_Transport::where('trans_status', 1)->where('customer_id', $customer_id)->first();
        if($find_static){
            $add_address_trans = new Customer_Transport();
            $add_address_trans->customer_id = $customer_id;
            $add_address_trans->trans_fullname = $name;
            $add_address_trans->trans_phone = $phone;
            $add_address_trans->trans_address = $address_trans;
            $add_address_trans->save();
        }
        else{
            $add_address_trans = new Customer_Transport();
            $add_address_trans->customer_id = $customer_id;
            $add_address_trans->trans_fullname = $name;
            $add_address_trans->trans_phone = $phone;
            $add_address_trans->trans_address = $address_trans;
            $add_address_trans->trans_status = 1;
            $add_address_trans->save();
        }
    }
    function generateRandomString($length = 4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function check_qty_to_checkout(Request $request){
        $trans_id = $request->trans_id;
        $payment_method = $request->payment_method;
        $cart_id = $request->cart_id;
        $summary_total_order = $request->summary_total_order;
        $date = date('Ymd');
        $check = 1;
        $all_storage_product = Storage_Product::all();
        if($trans_id == null || $trans_id == ""){
            echo 2;
        }
        else{
            foreach ($cart_id as $id){
                $cart = Cart::find($id);
                foreach ($all_storage_product as $storage_product){
                    if($cart->product_id == $storage_product->product_id){
                        $qty_cart = $cart->quantity;
                        $qty_sto = $storage_product->total_quantity_product;
                        if($qty_cart > $qty_sto){
                            $check = 0;

                        }
                        else{
                            $check = 1;
                        }
                    }
                }
            }
            echo $check;
        }

    }
    public function process_checkout(Request $request){

        $trans_id = $request->trans_id;
        $payment_method = $request->payment_method;
        $cart_id = $request->cart_id;
        $summary_total_order = $request->summary_total_order;
        $fee_ship = $request->fee_ship;
        $customer_id = Session::get('customer_id');
        $check = 1;
        $all_storage_product = Storage_Product::all();

        if($request->voucher_code){
            $voucher_code = $request->voucher_code;
        }
        else{
            $voucher_code = null;
        }
        $date = date('Ymd');
        // check qty after check out
        foreach ($cart_id as $id){
            $cart = Cart::find($id);
            foreach ($all_storage_product as $storage_product){
                if($cart->product_id == $storage_product->product_id){
                    $qty_cart = $cart->quantity;
                    $qty_sto = $storage_product->total_quantity_product;
                    if($qty_cart > $qty_sto){
                        $check = 0;
                    }
                }
            }
        }
        if($check == 1){
            if($payment_method == 0){
                //delete voucher
                if($request->voucher_code){
                    $voucher = Voucher::where('voucher_code', $voucher_code)->first();
                    $update_status_voucher = Storage_Customer_Voucher::where('voucher_id',$voucher->voucher_id)->where('customer_id', $customer_id)->first();
                    $update_status_voucher->status = 0;
                    $update_status_voucher->save();
                }

                $orders = new Orders();
                $orders->order_code = $date.''.$this->generateRandomString();
                $orders->customer_id = Session::get('customer_id');
                $orders->total_price = $summary_total_order;
                $orders->payment_id = $payment_method;
                $orders->trans_id = $trans_id;
                $orders->voucher_code = $voucher_code;
                $orders->fee_ship = $fee_ship;
                $orders->create_at = Carbon::now('Asia/Ho_Chi_Minh');
                $orders->save();
                //
                foreach ($cart_id as $id){
                    $cart = Cart::find($id);

                    $order_item = new Order_Item();
                    $order_item->product_id = $cart->product_id;
                    $order_item->order_id = $orders->order_id;
                    $order_item->quantity_product = $cart->quantity;

                    //
                    $price_product = ProductPrice::where('product_id',$cart->product_id)->where('status',1)->first();
                    $callFunction = new HomeClientController;
                    $price_discount = $callFunction->check_price_discount($cart->product_id);
                    $order_item->price_product = $price_discount->price_now;
                    $order_item->save();

                    foreach ($all_storage_product as $storage_product){
                        if($cart->product_id == $storage_product->product_id){
                            $qty_cart = $cart->quantity;
                            $qty_sto = $storage_product->total_quantity_product;
                            $update_storage_product = Storage_Product::where('product_id',$storage_product->product_id)->first();
                            $update_storage_product -> total_quantity_product = $qty_sto - $qty_cart;
                            $update_storage_product->save();
                        }
                    }

                    $delete_cart = Cart::find($id);
                    $delete_cart->delete();
                }

                //
                $order_detail_status = new Order_Detail_Status();
                $order_detail_status->order_id = $orders->order_id;
                $order_detail_status->status_id = 1;
                $order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
                $order_detail_status->status = 1;
                $order_detail_status->save();

                return view('client.checkout.view_checkout_success',[
                    'orders' => $orders,
                    'payment_method' => $payment_method,
                    'summary_total_order' => $summary_total_order,
                    'status' => $orders->status_pay,
                ]);
            }
            else{
                //delete voucher
                if($request->voucher_code){
                    $voucher = Voucher::where('voucher_code', $voucher_code)->first();
                    $update_status_voucher = Storage_Customer_Voucher::where('voucher_id',$voucher->voucher_id)->where('customer_id', $customer_id)->first();
                    $update_status_voucher->status = 0;
                    $update_status_voucher->save();
                }

                $orders = new Orders();
                $orders->order_code = $date.''.$this->generateRandomString();
                $orders->customer_id = Session::get('customer_id');
                $orders->total_price = $summary_total_order;
                $orders->payment_id = $payment_method;
                $orders->trans_id = $trans_id;
                $orders->voucher_code = $voucher_code;
                $orders->fee_ship = $fee_ship;
                $orders->status_pay = 1;
                $orders->create_at = Carbon::now('Asia/Ho_Chi_Minh');
                $orders->save();
                //
                foreach ($cart_id as $id){
                    $cart = Cart::find($id);

                    $order_item = new Order_Item();
                    $order_item->product_id = $cart->product_id;
                    $order_item->order_id = $orders->order_id;
                    $order_item->quantity_product = $cart->quantity;

                    //
                    $price_product = ProductPrice::where('product_id',$cart->product_id)->where('status',1)->first();
                    $callFunction = new HomeClientController;
                    $price_discount = $callFunction->check_price_discount($cart->product_id);
                    $order_item->price_product = $price_discount->price_now;
                    $order_item->save();

                    foreach ($all_storage_product as $storage_product){
                        if($cart->product_id == $storage_product->product_id){
                            $qty_cart = $cart->quantity;
                            $qty_sto = $storage_product->total_quantity_product;
                            $update_storage_product = Storage_Product::where('product_id',$storage_product->product_id)->first();
                            $update_storage_product -> total_quantity_product = $qty_sto - $qty_cart;
                            $update_storage_product->save();
                        }
                    }

                    $delete_cart = Cart::find($id);
                    $delete_cart->delete();
                }

                //
                $order_detail_status = new Order_Detail_Status();
                $order_detail_status->order_id = $orders->order_id;
                $order_detail_status->status_id = 1;
                $order_detail_status->time_status = Carbon::now('Asia/Ho_Chi_Minh');
                $order_detail_status->status = 1;
                $order_detail_status->save();



                $vnd_to_usd = $summary_total_order/23022;
                return view('client.checkout.check_out_paypal',[
                    'vnd_to_usd'=>$vnd_to_usd,

                    'orders' => $orders,
                    'payment_method' => $payment_method,
                    'summary_total_order' => $summary_total_order,
                    'status' => $orders->status_pay,
                    'voucher_code' => $voucher_code,
                ]);
            }
        }
        else{
            return view('client.checkout.over_product_when_checkout');
        }

    }
    public function check_out_success(){
        return view('client.checkout.view_checkout_success');
    }
    public function view_checkout_paypal_success(
        $payment_method,
        $summary_total_order,
        $status,
        $order_code
    ){
        return view('client.checkout.view_checkout_paypal_success',[
            'payment_method'=>$payment_method,
            'summary_total_order'=>$summary_total_order,
            'status'=>$status,
            'order_code'=>$order_code,
        ]);
    }
    public function view_checkout_paypal_fail($order_id){
        // return voucher_code
        $voucher = Orders::find($order_id);
        $voucher_id = Voucher::where('voucher_code', $voucher->voucher_code)->first();
        if($voucher_id){
            $update_voucher = Storage_Customer_Voucher::where('voucher_id',$voucher_id->voucher_id)->where('customer_id',Session::get('customer_id'))->first();
            $update_voucher->status = 1;
            $update_voucher->save();

        }

        $order_item = Order_Item::where('order_id', $order_id)->get();
        foreach($order_item as $item){
            $re_add_cart = new Cart();
            $re_add_cart->customer_id = Session::get('customer_id');
            $re_add_cart->product_id = $item->product_id;
            $re_add_cart->quantity = $item->quantity_product;
            $re_add_cart->save();

            // re add quantity storage_product
            $storage_product = Storage_Product::where('product_id', $item->product_id)->first();
            $storage_product->total_quantity_product = $storage_product->total_quantity_product + $item->quantity_product;
            $storage_product->save();

            // delete order items
            $delete_item = Order_Item::find($item->order_item_id);
            $delete_item->delete();
        }
        // delete order
        $delete_order = Orders::find($order_id);
        $delete_order->delete();

        // delete order status
        $delete_order_status = Order_Detail_Status::where('order_id', $order_id)->where('status', 1)->first();
        $delete_order_status->delete();

        return view('client.checkout.view_checkout_paypal_fail');
    }
    public function check_voucher_code_to_apply(Request $request){
        $voucher_code = $request->input_voucher_code;
        $check_discount_voucher = Voucher::where('voucher_code',$voucher_code)->first();
        $obVal = array(
            'product' => 0,
            'voucher_amount' => 0
        );
        if($check_discount_voucher){
            $check_voucher_in_storage = Storage_Customer_Voucher::where('voucher_id', $check_discount_voucher->voucher_id)->where('status', 1)->where('customer_id', Session::get('customer_id'))->first();
            if($check_voucher_in_storage){
                if($check_discount_voucher){
                    $obVal = array(
                        'product' => $check_discount_voucher->product_id,
                        'voucher_amount' => $check_discount_voucher->voucher_amount
                    );
                }
            }
        }
        echo json_encode($obVal);
    }
}
