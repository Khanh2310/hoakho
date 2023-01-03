<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\WishList;
use App\Product;

Session::start();
class WishListController extends Controller
{
    function check_login(){
        $session = Session::get('customer_id');
        if($session == "" || $session == null){
            return redirect('login_client')->send();
        }
    }
    public static function checkProductWishLish($product_id){
        $Ob_wishlist = (object)[];
        $customer_id = Session::get('customer_id');
        $check_wish_list = WishList::where('customer_id',$customer_id)->where('product_id',$product_id)->first();
        if($check_wish_list){
            $Ob_wishlist = (object) [
                'check_already' => 1,
            ];
        }
        else{
            $Ob_wishlist = (object) [
                'check_already' => 0,
            ];
        }
        return $Ob_wishlist;
    }
    public function add_wish_list_ajax(Request $request){

        $product_id = $request->product_id;
        $customer_id = Session::get('customer_id');

        $check_wish_list = WishList::where('customer_id',$customer_id)->where('product_id',$product_id)->first();
        if($check_wish_list){
            echo 0;
        }
        else{
            $add_wish_list = new WishList();
            $add_wish_list->customer_id = $customer_id;
            $add_wish_list->product_id = $product_id;
            $result_add_wish_list = $add_wish_list->save();
            if($result_add_wish_list){
                echo 1;
            }
        }
    }
    public function load_wish_list_ajax(){
        $customer_id = Session::get('customer_id');
        $all_product = Product::all();

        $load_wish_list_ajax = WishList::where('customer_id', $customer_id)->get();

        echo view('client.wishlist.mini_wish_list',[
            'wish_lish'=>$load_wish_list_ajax,
            'all_product'=>$all_product,
        ]);
    }
    public function count_total_wish_list_ajax(){
        $customer_id = Session::get('customer_id');

        $count_total_wish_list = WishList::where('customer_id', $customer_id)->get();

        echo count($count_total_wish_list);
    }

    public function remove_item_wish_list(Request $request){
        $wish_list_id = $request->wish_list_id;

        $delete_wish_list = WishList::find($wish_list_id);
        $delete_wish_list->delete();
        return redirect()->back();
    }
}
