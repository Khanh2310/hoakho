<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductPrice;
use App\ImageProduct;
use App\Cart;
use App\Storage_Product;
use App\Order_Detail_Status;
use App\Order_Item;
use App\Orders;
use App\Comment;
use App\Rating;
use App\Customer;
use App\Customer_Info;
use App\Discount;
use App\Storage_Customer_Voucher;
use App\Voucher;
use App\WishList;

use Session;
use DB;
use Carbon\Carbon;

Session::start();

class ShopController extends Controller
{
    public function shop_product(){
        $customer_id = Session::get('customer_id');
        $all_category = Category::all();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        $product_storage = Storage_Product::all();

        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();


        $callFunction = new HomeClientController;

        // ALL PRODUCT DISCOUNT
        $arrayProductDiscount = array();
        $get_all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->join('storage_product','storage_product.product_id','=','product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at',null)
            ->get();
        foreach($get_all_product as $product){
            $check_discount = $callFunction->check_price_discount($product->product_id);
            if($check_discount->percent_discount > 0){
                $product->percent_discount =  $check_discount->percent_discount;
                $arrayProductDiscount[] = $product;
            }
        }
        $all_product_discount = collect($arrayProductDiscount)->sortBy('percent_discount')->reverse()->toArray();
        // END ALL PRODUCT DISCOUNT

        // PRODUCT RECOMMEND
        $all_product_recommend = DB::table('product')
        ->join('category','category.cate_id','=','product.category_id')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)
        ->get();

        return view('client.shop.shop_product', [
            'all_category'=>$all_category,
            'all_product'=>$all_product,
            'all_price' =>$all_price,
            'all_cart' => $all_cart,
            'wish_lish' => $wish_lish,
            'product_storage' => $product_storage,

            'all_product_discount' => $all_product_discount,
            'all_product_recommend' => $all_product_recommend,

        ]);
    }

    public function ajax_sort_cate_shop(Request $request){
        $cate_id = $request->cate_id;
        $type_filter = 'cate';
        $level_filter = $cate_id;
        $result_sort = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->where('product_price.status', 1)
            ->where('cate_id',$cate_id)
            ->where('product.deleted_at', null)
            ->get();

        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$result_sort,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);
    }

    public function ajax_sort_rating_shop(Request $request){
        $rating = $request->rating;
        $type_filter = 'rating';
        $level_filter = $rating;
        $arrayProduct = array();
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->get();

        $callFunction = new HomeClientController;
        foreach($all_product as $product){
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            if($check_rating->avg_rating >= $rating){
                $product->rating = $check_rating->avg_rating;
                $arrayProduct[] = $product;
            }

        }
        //sortByDesc ->(low to height)
        $orderByArrayProduct = collect($arrayProduct)->sortBy('rating')->reverse()->toArray();
        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);
    }
    public function ajax_sort_price_enter_shop(Request $request){
        $price_start = $request->price_start;
        $price_end = $request->price_end;
        $type_filter = 'price';
        $level_filter = '';
        $level_filter_price_start = $price_start;
        $level_filter_price_end = $price_end;

        $arrayProduct = array();
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->get();

        $callFunction = new HomeClientController;
        foreach($all_product as $product){
            $check_price = $callFunction->check_price_discount($product->product_id);
            $price_now = number_format($check_price->price_now,0,',','');
            if($price_start <= $price_now && $price_now <= $price_end){
                $product->price_now =  $price_now;
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }
    public function sort_price_ajax_shop_select(Request $request){
        $val_sort_price = $request->val_sort_price;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $callFunction = new HomeClientController;

        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product.category_id', $level_filter)
                        ->get();
        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();
            $arrTemp = array();

            foreach($all_product_get as $product){
                $check_rating = $callFunction->info_rating_saled($product->product_id);
                if($check_rating->avg_rating >= $level_filter){
                    $product->rating = $check_rating->avg_rating;
                    $arrTemp[] = $product;

                }
            }
            $all_product = (object)$arrTemp;
        }
        else if($type_filter == 'price'){
            $level_filter_price_start = $request->level_filter_price_start;
            $level_filter_price_end = $request->level_filter_price_end;
            $arrTemp = array();
            $all_product_get = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('category', 'category.cate_id', '=', 'product.category_id')
                ->where('product_price.status', 1)
                ->where('product.deleted_at', null)
                ->get();
            foreach($all_product_get as $product){
                $check_price = $callFunction->check_price_discount($product->product_id);
                $price_now = number_format($check_price->price_now,0,',','');
                if($level_filter_price_start <= $price_now && $price_now <= $level_filter_price_end){
                    $product->price_now =  $price_now;
                    $arrTemp[] = $product;
                }
            }
            $all_product = (object)$arrTemp;
        }
        else{
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();

        }

        //
        $arrayProduct = array();
        foreach($all_product as $product){
            $check_price = $callFunction->check_price_discount($product->product_id);
            $price_now = number_format($check_price->price_now,0,',','');
            $product->price_now =  $price_now;
            $arrayProduct[] = $product;
        }
        if($val_sort_price == 'desc'){
            $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
        }
        else{
            $orderByArrayProduct = collect($arrayProduct)->sortBy('price_now')->reverse()->toArray();
        }

        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
        //echo(count($orderByArrayProduct));
    }

    public function sort_rating_ajax_shop_select(Request $request){
        $sort_rating_fiter = $request->sort_rating_fiter;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $callFunction = new HomeClientController;

        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product.category_id', $level_filter)
                        ->get();

        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();
            $arrTemp = array();

            foreach($all_product_get as $product){
                $check_rating = $callFunction->info_rating_saled($product->product_id);
                if($check_rating->avg_rating >= $level_filter){
                    $product->rating = $check_rating->avg_rating;
                    $arrTemp[] = $product;

                }
            }
            $all_product = (object)$arrTemp;
        }
        else if($type_filter == 'price'){
            $level_filter_price_start = $request->level_filter_price_start;
            $level_filter_price_end = $request->level_filter_price_end;
            $arrTemp = array();
            $all_product_get = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('category', 'category.cate_id', '=', 'product.category_id')
                ->where('product_price.status', 1)
                ->where('product.deleted_at', null)
                ->get();
            foreach($all_product_get as $product){
                $check_price = $callFunction->check_price_discount($product->product_id);
                $price_now = number_format($check_price->price_now,0,',','');
                if($level_filter_price_start <= $price_now && $price_now <= $level_filter_price_end){
                    $product->price_now =  $price_now;
                    $arrTemp[] = $product;
                }
            }
            $all_product = (object)$arrTemp;
        }
        else{
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();

        }
        $arrayProduct = array();
        foreach($all_product as $product){
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            $product->rating = $check_rating->avg_rating;
            $arrayProduct[] = $product;
        }
        if($sort_rating_fiter == 'desc'){
            $orderByArrayProduct = collect($arrayProduct)->sortByDesc('rating')->reverse()->toArray();
        }
        else{
            $orderByArrayProduct = collect($arrayProduct)->sortBy('rating')->reverse()->toArray();
        }

        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }

    public function sort_discount_ajax_shop_select(Request $request){
        $sort_discount_fiter = $request->sort_discount_fiter;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $callFunction = new HomeClientController;

        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product.category_id', $level_filter)
                        ->get();

        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();
            $arrTemp = array();

            foreach($all_product_get as $product){
                $check_rating = $callFunction->info_rating_saled($product->product_id);
                if($check_rating->avg_rating >= $level_filter){
                    $product->rating = $check_rating->avg_rating;
                    $arrTemp[] = $product;

                }
            }
            $all_product = (object)$arrTemp;
        }
        else if($type_filter == 'price'){
            $level_filter_price_start = $request->level_filter_price_start;
            $level_filter_price_end = $request->level_filter_price_end;
            $arrTemp = array();
            $all_product_get = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('category', 'category.cate_id', '=', 'product.category_id')
                ->where('product_price.status', 1)
                ->where('product.deleted_at', null)
                ->get();
            foreach($all_product_get as $product){
                $check_price = $callFunction->check_price_discount($product->product_id);
                $price_now = number_format($check_price->price_now,0,',','');
                if($level_filter_price_start <= $price_now && $price_now <= $level_filter_price_end){
                    $product->price_now =  $price_now;
                    $arrTemp[] = $product;
                }
            }
            $all_product = (object)$arrTemp;
        }
        else{
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->get();

        }
        $arrayProduct = array();
        foreach($all_product as $product){
            $check_price = $callFunction->check_price_discount($product->product_id);
            if($check_price->percent_discount > 0){
                $product->percent_discount =  $check_price->percent_discount;
                $arrayProduct[] = $product;
            }
        }
        if($sort_discount_fiter == 'desc'){
            $orderByArrayProduct = collect($arrayProduct)->sortByDesc('percent_discount')->reverse()->toArray();
        }
        else{
            $orderByArrayProduct = collect($arrayProduct)->sortBy('percent_discount')->reverse()->toArray();
        }

        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }
    public function filter_modal_shop_ajax(Request $request){
        $cate_id = $request->cate_id;
        $rating = $request->rating;
        $price_start_filter = $request->price_start_filter;
        $price_end_filter = $request->price_end_filter;

        $callFunction = new HomeClientController;
        $arrayProduct = array();
        $arrayProductPrice = array();

        if($cate_id != ''){
            $result_sort = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('category', 'category.cate_id', '=', 'product.category_id')
                ->where('product_price.status', 1)
                ->where('product.deleted_at', null)
                ->where('category.cate_id', $cate_id)
                ->get();
        }
        else{
            $result_sort = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('category', 'category.cate_id', '=', 'product.category_id')
                ->where('product_price.status', 1)
                ->where('product.deleted_at', null)
                ->get();
        }
        //echo count($result_sort);
        if(count($result_sort) > 0){
            foreach($result_sort as $product){
                $check_rating = $callFunction->info_rating_saled($product->product_id);
                if($check_rating->avg_rating >= $rating){
                    $product->avg_rating =  $check_rating->avg_rating;
                    $arrayProduct[] = $product;
                }
            }
            $result_sort = collect($arrayProduct)->sortByDesc('avg_rating')->reverse()->toArray();
            if($price_start_filter != 0 && $price_end_filter != 0){
                foreach($result_sort as $product){
                    $check_price = $callFunction->check_price_discount($product->product_id);
                    $price_now = number_format($check_price->price_now,0,',','');
                    if($price_start_filter <= $price_now && $price_now <= $price_end_filter){
                        $product->price_now =  $check_price->price_now;
                        $arrayProductPrice[] = $product;
                    }
                }
                if(count($arrayProductPrice) > 0){
                    $result_sort = collect($arrayProductPrice)->sortByDesc('price_now')->reverse()->toArray();
                }
                else{
                    $result_sort = array();
                }

            }
        }
        else{
            $result_sort = array();
        }

        echo view('client.shop.list_item_sort_shop',[
            'result_sort'=>$result_sort
        ]);

    }
}
