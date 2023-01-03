<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;
use Carbon\Carbon;
use App\Storage_Product;
use App\Product;
use App\ProductPrice;
use App\WishList;

Session::start();
class CartController extends Controller
{
    public function add_cart(Request $request){
        $product_id = $request->product_id;
        $qty = $request->qty;
        $customer_id = Session::get('customer_id');

        $product_storage = Storage_Product::where('product_id',$product_id)->first();
        $product_storage_quantity = $product_storage->total_quantity_product;
        if($qty <= $product_storage_quantity){
            $check_cart = Cart::where('customer_id',$customer_id)->where('product_id',$product_id)->where('status',1)->first();
            if($check_cart){
                $total_quantity_cart = $qty + $check_cart->quantity;
                if($total_quantity_cart <= $product_storage_quantity){
                    $cart_id = $check_cart->cart_id;
                    $update_cart = Cart::find($cart_id);
                    $update_cart->quantity = $check_cart->quantity + $qty;
                    $update_cart->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $update_cart->save();
                    echo 1;
                }
                else{
                    $qty_in_cart = $check_cart->quantity;
                    $div_qty_cart = $product_storage_quantity - $qty_in_cart;
                    echo $div_qty_cart;
                }
            }
            else{
                $add_cart = new Cart();
                $add_cart->customer_id = $customer_id;
                $add_cart->product_id = $product_id;
                $add_cart->quantity = $qty;
                $add_cart->save();
                echo 1;
            }
        }
        else{
            echo 0;
        }
    }
    public function load_quantity_cart(){
        $customer_id = Session::get('customer_id');
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        echo count($all_cart);
    }
    public function show_cart(){
        $this->auto_update_cart();
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id',$customer_id)->where('status', 1)->get();
        $old_date_cart = Cart::where('customer_id', $customer_id)->where('status', 0)->get();
        $all_product = Product::all();
        $product_storage = Storage_Product::all();
        $product_price = ProductPrice::where('status',1)->get();
        $all_price = ProductPrice::where('status',1)->get();
        $total_price_all_cart = 0;

        foreach ($all_cart as $cart){
            foreach ($product_price as $price){
                if($cart->product_id == $price->product_id){
                    // call another function
                    $callFunction = new HomeClientController;
                    $price_discount = $callFunction->check_price_discount($cart->product_id);
                    $price = $price_discount->price_now;
                    $qty = $cart->quantity;
                   $total_price_all_cart += $price * $qty;
                }
            }
        }

        return view('client.cart.show_cart',[
            'all_cart' => $all_cart,
            'all_product' => $all_product,
            'wish_lish' => $wish_lish,
            'product_storage' => $product_storage,
            'product_price' => $product_price,
            'old_date_cart' => $old_date_cart,
            'total_price_all_cart' => $total_price_all_cart,
            'all_price' => $all_price
        ]);
    }
    public function auto_update_cart(){
        $customer_id = Session::get('customer_id');
        $all_cart = Cart::where('customer_id',$customer_id)->where('status',1)->get();
        $old_date_cart = Cart::where('customer_id', $customer_id)->where('status', 0)->get();
        $all_product = Product::all();
        $product_storage = Storage_Product::all();
        $product_price = ProductPrice::where('status',1)->get();
        foreach ($all_cart as $cart){
            foreach ($product_storage as $prod_sto){
                if($cart->product_id == $prod_sto->product_id){
                    if($prod_sto->total_quantity_product == 0){
                        $update_cart = Cart::find($cart->cart_id);
                        $update_cart->status = 0;
                        $update_cart->save();
                    }
                    else{
                        if($cart->quantity > $prod_sto->total_quantity_product){
                            $qty_sto = $prod_sto->total_quantity_product;
                            $qty_cart = $cart->quantity;
                            $check_qty = $qty_cart - $qty_sto;
                            $check_qty = abs($check_qty);
                            $update_cart = Cart::find($cart->cart_id);
                            $update_cart->quantity = $qty_cart - $check_qty;
                            $update_cart->save();
                        }
                    }
                }
            }
        }
        // update old date cart
        foreach ($old_date_cart as $old){
            foreach ($product_storage as $prod_sto){
                if($old->product_id == $prod_sto->product_id){
                    if($old->quantity >= $prod_sto->total_quantity_product && $prod_sto->total_quantity_product > 0){
                        $qty_sto = $prod_sto->total_quantity_product;
                        $qty_cart = $old->quantity;
                        $check_qty = $qty_cart - $qty_sto;
                        $check_qty = abs($check_qty);
                        $update_cart_old = Cart::find($old->cart_id);
                        $update_cart_old->quantity = $qty_cart - $check_qty;
                        $update_cart_old->status = 1;
                        $update_cart_old->save();
                    }
                    else{
                        if($old->quantity < $prod_sto->total_quantity_product){
                            $update_cart_old = Cart::find($old->cart_id);
                            $update_cart_old->status = 1;
                            $update_cart_old->save();
                        }
                    }
                }
            }
        }
    }
    public function update_cart(Request $request){
        $cart_id = $request->cart_id;
        $qty = $request->qty;
        $customer_id = Session::get('customer_id');
        $cart = Cart::find($cart_id);

        $product_storage = Storage_Product::where('product_id',$cart->product_id)->first();
        $product_storage_quantity = $product_storage->total_quantity_product;

        if($qty <= $product_storage_quantity){
            if($qty <= 0){
                echo 1;
            }
            else{
                $update_cart = Cart::find($cart_id);
                $update_cart->quantity = $qty;
                $update_cart->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $update_cart->save();
                echo $qty;
            }
        }
        else{
            echo 0;
        }
    }
    public function update_cart_checkbox(Request $request){
        $cart_id = $request->cart_id;
        $qty = $request->qty;
        $customer_id = Session::get('customer_id');
        $cart = Cart::find($cart_id);

        $product_storage = Storage_Product::where('product_id',$cart->product_id)->first();
        $product_storage_quantity = $product_storage->total_quantity_product;

        if($qty <= $product_storage_quantity){
            $update_cart = Cart::find($cart_id);
            $update_cart->quantity = $qty;
            $update_cart->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $update_cart->save();
            echo $qty;
        }
    }
    public function check_quatity_blur(Request $request){
        $cart_id = $request->cart_id;
        $cart = Cart::find($cart_id);
        $litmit_qty = Storage_Product::where('product_id',$cart->product_id)->first();
        echo $litmit_qty->total_quantity_product;
    }
    public function remove_item_cart(Request $request){
        $cart_id = $request->cart_id;
        $remove_item_cart = Cart::find($cart_id);
        $remove_item_cart->delete();
        return redirect()->back();
    }

    public function update_qty_when_change(Request $request){
        $customer_id = Session::get('customer_id');
        $product_id = $request->product_id;
        $cart = Cart::where('customer_id', $customer_id)->where('product_id', $product_id)->where('status',1)->first();
        $qty = $cart->quantity;
        echo $qty;
    }
    public function update_qty_when_update_cart(Request $request){
        $customer_id = Session::get('customer_id');
        $cart_id = $request->cart_id;
        $cart = Cart::find($cart_id);
        $qty = $cart->quantity;
        echo $qty;
    }
    public function show_mini_cart_when_add(Request $request){
        // $product_id = $request->product_id;
        // $check = Cart::where('product_id',$product_id)->where('customer_id',Session::get('customer_id'))->first();
        // if(!$check){
            $all_cart = Cart::where('customer_id', Session::get('customer_id'))->where('status', 1)->get();
            $all_product = Product::all();
            $all_price = ProductPrice::where('status',1)->get();
            echo view('client.cart.mini_cart_ajax',[
                'all_cart'=> $all_cart,
                'all_product'=> $all_product,
                'all_price'=> $all_price,
            ]);
        //}
    }
}
