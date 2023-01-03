<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;

class AjaxSearchProductKeyword extends Controller
{
    public function ajax_search_cate_and_keyword(Request $request){
        $keyword = $request->keyword_search;
        $cate_id = $request->cate_id;
        $type_filter = 'cate';
        $level_filter = $cate_id;
        $result_search = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->where('product_price.status', 1)
            ->where('product_name','LIKE','%'.$keyword.'%')
            ->where('cate_id',$cate_id)
            ->where('product.deleted_at', null)
            ->get();
        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$result_search,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);
    }
    public function ajax_search_rating_and_keyword(Request $request){
        $keyword = $request->keyword_search;
        $rating = $request->rating;
        $type_filter = 'rating';
        $level_filter = $rating;

        $arrayProduct = array();
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->where('product_price.status', 1)
            ->where('product_name','LIKE','%'.$keyword.'%')
            ->where('product.deleted_at', null)
            ->get();

        $callFunction = new HomeClientController;
        foreach($all_product as $product){
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            if($check_rating->avg_rating >= $rating){
                // $arrayProduct[] = [
                //     'product_id' => $product->product_id,
                //     'avg_rating' => $check_rating->avg_rating,
                //     'question_id' => '2',
                // ];
                $product->rating = $check_rating->avg_rating;
                $arrayProduct[] = $product;

            }

        }
        //sortByDesc ->(low to height)
        $orderByArrayProduct = collect($arrayProduct)->sortBy('rating')->reverse()->toArray();
        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
        ]);

    }
    public function ajax_search_price_and_keyword(Request $request){
        $keyword = $request->keyword_search;
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
            ->where('product_name','LIKE','%'.$keyword.'%')
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
        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);

    }
    public function ajax_sort_price_and_keyword(Request $request){
        $keyword = $request->keyword_search;
        $val_sort_price = $request->val_sort_price;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $arrayProduct = array();
        $callFunction = new HomeClientController;
        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.category_id', $level_filter)
                        ->get();
        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
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
                ->where('product_name','LIKE','%'.$keyword.'%')
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
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.deleted_at', null)
                        ->get();
        }

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

        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }
    public function ajax_sort_rating_and_keyword(Request $request){
        $keyword = $request->keyword_search;
        $sort_rating_fiter = $request->sort_rating_fiter;

        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $arrayProduct = array();
        $callFunction = new HomeClientController;
        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.category_id', $level_filter)
                        ->get();
        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
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
                ->where('product_name','LIKE','%'.$keyword.'%')
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
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.deleted_at', null)
                        ->get();
        }
        //
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

        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }
    public function ajax_sort_discount_and_keyword(Request $request){
        $keyword = $request->keyword_search;
        $sort_discount_fiter = $request->sort_discount_fiter;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;
        $level_filter_price_start = $request->level_filter_price_start;
        $level_filter_price_end = $request->level_filter_price_end;

        $arrayProduct = array();
        $callFunction = new HomeClientController;
        if($type_filter == "cate"){
            $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.category_id', $level_filter)
                        ->get();
        }
        else if($type_filter == 'rating'){
            $all_product_get = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product.deleted_at', null)
                        ->where('product_name','LIKE','%'.$keyword.'%')
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
                ->where('product_name','LIKE','%'.$keyword.'%')
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
                        ->where('product_name','LIKE','%'.$keyword.'%')
                        ->where('product.deleted_at', null)
                        ->get();
        }
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

        echo view('client.home.list_item_search_keyword',[
            'result_search'=>$orderByArrayProduct,
            'type_filter'=>$type_filter,
            'level_filter'=>$level_filter,
            'level_filter_price_start'=>$level_filter_price_start,
            'level_filter_price_end'=>$level_filter_price_end,
        ]);
    }
}
