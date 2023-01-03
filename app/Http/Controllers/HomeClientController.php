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
class HomeClientController extends Controller
{
    public static function check_price_discount($product_id){
        $product = DB::table('product')
                ->join('product_price','product_price.product_id','=','product.product_id')
                ->where('product_price.status',1)->where('product.product_id',$product_id)->first();
        $discount = Discount::find($product->discount_id);
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $Ob_price = (object)[];
        if($product->discount_id == null){
            $Ob_price = (object) [
                'percent_discount' => 0,
                'price_now' => $product->price,
                'price_old' => 0,
                'date_end_discount' => null
            ];
        }
        else{
            if($discount->start_date_2 != ''){
                if ($now >= $discount->start_date_2 && $now <= $discount->end_date_2){
                    if($discount->condition_discount_2 ==1){
                        $price_discount = ($product->price * $discount->amount_discount_2) / 100;
                        $price_now = $product->price - $price_discount;
                    }
                    else{
                        $price_now = $product->price - $discount->amount_discount_2;
                    }
                    $percent_discount = 100 - ($price_now *100)/$product->price;
                    $Ob_price = (object) [
                        'percent_discount' => $percent_discount,
                        'price_now' => $price_now,
                        'price_old' => $product->price,
                        'date_end_discount' => $discount->end_date_2
                    ];
                }
                else{
                    if($now >= $discount->start_date_1 && $now <= $discount->end_date_1){
                        if($discount->condition_discount_1 ==1){
                            $price_discount = ($product->price * $discount->amount_discount_1) / 100;
                            $price_now = $product->price - $price_discount;
                        }
                        else{
                            $price_now = $product->price - $discount->amount_discount_1;
                        }
                        $percent_discount = 100 - ($price_now *100)/$product->price;
                        $Ob_price = (object) [
                            'percent_discount' => $percent_discount,
                            'price_now' => $price_now,
                            'price_old' => $product->price,
                            'date_end_discount' => $discount->end_date_1
                        ];
                    }
                    else{
                        $Ob_price = (object) [
                            'percent_discount' => 0,
                            'price_now' => $product->price,
                            'price_old' => 0,
                            'date_end_discount' => null
                        ];
                    }
                }
            }
            else{
                if($now >= $discount->start_date_1 && $now <= $discount->end_date_1){
                    if($discount->condition_discount_1 ==1){
                        $price_discount = ($product->price * $discount->amount_discount_1) / 100;
                        $price_now = $product->price - $price_discount;
                    }
                    else{
                        $price_now = $product->price - $discount->amount_discount_1;
                    }
                    $percent_discount = 100 - ($price_now *100)/$product->price;
                    $Ob_price = (object) [
                        'percent_discount' => $percent_discount,
                        'price_now' => $price_now,
                        'price_old' => $product->price,
                        'date_end_discount' => $discount->end_date_1
                    ];
                }
                else{
                    $Ob_price = (object) [
                        'percent_discount' => 0,
                        'price_now' => $product->price,
                        'price_old' => 0,
                        'date_end_discount' => null
                    ];
                }
            }
        }
        return $Ob_price;
    }
    public static function info_rating_saled($product_id){
        //Count rating
        $rating_5 = count(Rating::where('product_id',$product_id)->where('rating_level', 5)->get());
        $rating_4 = count(Rating::where('product_id',$product_id)->where('rating_level', 4)->get());
        $rating_3 = count(Rating::where('product_id',$product_id)->where('rating_level', 3)->get());
        $rating_2 = count(Rating::where('product_id',$product_id)->where('rating_level', 2)->get());
        $rating_1 = count(Rating::where('product_id',$product_id)->where('rating_level', 1)->get());

        $all_rating = count(Rating::where('product_id',$product_id)->get());
        if ($all_rating != 0){
            $avg_rating = (($rating_5*5)+($rating_4*4)+($rating_3*3)+($rating_2*2)+($rating_1*1))/$all_rating;
        }
        else{
            $avg_rating = 0;
        }

        // count product saled
        $count_product_saled = DB::table('order_item')
                            ->join('orders', 'orders.order_id', '=', 'order_item.order_id')
                            ->join('order_detail_status', 'order_detail_status.order_id', '=', 'order_item.order_id')
                            ->where('order_item.product_id',$product_id)
                            ->where('order_detail_status.status_id', 4)
                            ->sum('quantity_product');
        $Ob_rating = (object) [
            'count_all_rating' => $all_rating,
            'avg_rating' => $avg_rating,
            'count_product_saled' => $count_product_saled,
        ];
        return $Ob_rating;
    }

    //
    public function index(){
        $customer_id = Session::get('customer_id');

        $all_category = Category::all();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();
        $product_storage = Storage_Product::all();
        $all_discount = Discount::all();

        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();

        $all_product_join = DB::table('product')
        ->join('category','category.cate_id','=','product.category_id')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)
        ->get();

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

        // DISCOUNT TODAY
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $arrayProductDiscountToday = array();
        foreach($get_all_product as $product){
            $check_discount = $callFunction->check_price_discount($product->product_id);
            if($check_discount->percent_discount > 0){
                $date_now = strtotime($now);
                $end_date_discount = strtotime($check_discount->date_end_discount);
                $minus_date = abs($end_date_discount - $date_now);
                $check_date = floor($minus_date / (60*60*24));
                if($check_date < 1){
                    $product->percent_discount =  $check_discount->percent_discount;
                    $arrayProductDiscountToday[] = $product;
                }
            }
        }
        $all_product_discount_today = collect($arrayProductDiscountToday)->sortBy('percent_discount')->reverse()->toArray();
        // END DISCOUNT TODAY

        // TOP RATING
        $arrayProductTopRating = array();
        foreach($get_all_product as $product){
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            if($check_rating->avg_rating > 3){
                $product->avg_rating =  $check_rating->avg_rating;
                $arrayProductTopRating[] = $product;
            }
        }
        $all_product_top_rating = collect($arrayProductTopRating)->sortBy('avg_rating')->reverse()->toArray();
        // END TOP RATING

        // PRODUCT FEATURE
        $all_product_feature = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->join('storage_product','storage_product.product_id','=','product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at',null)
            ->where('product.is_featured', 1)
            ->get();

        return view('client.home.trangchu',[
            'all_category'=>$all_category,
            'all_product'=>$all_product,
            'all_price' =>$all_price,
            'all_cart' => $all_cart,
            'wish_lish' => $wish_lish,
            'product_storage' => $product_storage,

            'all_product_join' => $all_product_join,
            'all_discount' => $all_discount,

            'all_product_discount' => $all_product_discount,
            'all_product_discount_today' => $all_product_discount_today,
            'all_product_top_rating' => $all_product_top_rating,
            'all_product_feature' => $all_product_feature,
        ]);
        //dd($all_product_join);
    }

    public function show_all_product_discount(){
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $callFunction = new HomeClientController;

        $arrayProductDiscount = array();
        $all_product_discount = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->join('storage_product','storage_product.product_id','=','product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at',null)
            ->get();
        foreach($all_product_discount as $product){
            $check_discount = $callFunction->check_price_discount($product->product_id);
            if($check_discount->percent_discount > 0){
                $product->percent_discount =  $check_discount->percent_discount;
                $arrayProductDiscount[] = $product;
            }
        }
        $all_product_discount = collect($arrayProductDiscount)->sortBy('percent_discount')->reverse()->toArray();

        return view('client.home.view_all_product_discount',[
            'all_product_discount'=>$all_product_discount,
            'all_cart'=>$all_cart,
            'wish_lish'=>$wish_lish,
            'all_product'=>$all_product,
        ]);
    }
    public function show_all_product_feature(){
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_product_feature = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('category', 'category.cate_id', '=', 'product.category_id')
            ->join('storage_product','storage_product.product_id','=','product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at',null)
            ->where('product.is_featured', 1)
            ->get();
        return view('client.home.view_all_product_feature',[
            'all_product_feature'=>$all_product_feature,
            'all_cart'=>$all_cart,
            'wish_lish'=>$wish_lish,
            'all_product'=>$all_product,
        ]);
    }
    public function show_all_product_recommend(){
        $customer_id = Session::get('customer_id');
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $all_product = Product::all();
        $all_product_recommend = DB::table('product')
        ->join('category','category.cate_id','=','product.category_id')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)
        ->get();
        return view('client.home.view_all_product_recommend',[
            'all_product_recommend'=>$all_product_recommend,
            'all_cart'=>$all_cart,
            'wish_lish'=>$wish_lish,
            'all_product'=>$all_product,
        ]);
    }

    public function product_detail($product_id){
        $customer_id = Session::get('customer_id');
        $product = Product::find($product_id);
        $cate = Category::where('cate_id',$product->category_id)->first();
        $price = ProductPrice::where('product_id',$product_id)->where('status', 1)->first();
        $all_image = ImageProduct::where('product_id',$product_id)->get();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $product_storage = Storage_Product::all();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();

        $all_product_relate = DB::table('product')
        ->join('category','category.cate_id','=','product.category_id')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)
        ->get();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $all_product_voucher = Voucher::where('product_id', $product_id)
                                        ->where('status', 1)
                                        ->where('start_date', '<=' , $date_now)
                                        ->where('end_date', '>=', $date_now)
                                        ->where('voucher.voucher_quantity', '>', 0)
                                        ->get();
        $storage_customer_voucher = DB::table('storage_customer_voucher')
                                    ->join('voucher', 'voucher.voucher_id', '=', 'storage_customer_voucher.voucher_id')
                                    ->where('voucher.product_id', $product_id)
                                    ->where('customer_id', $customer_id)->get();

        // able rating and comment
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->where('status',1)->where('order_detail_status.status_id',4)
                ->where('customer_id', Session::get('customer_id'))->get();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if($orders){
            foreach ($orders as $order){
                $date_now = strtotime($now);
                $order_time = strtotime($order->create_at);
                $minus_date = abs($date_now - $order_time);
                $check_date = floor($minus_date / (60*60*24));
                if($check_date <= 30){
                    $order_item = Order_Item::where('order_id', $order->order_id)->get();
                    foreach ($order_item as $item){
                        if($item->product_id == $product_id){
                            Session::put('able_rating_comment_'.$product_id, $product_id);

                            $find_rating = Rating::where('product_id',$product_id)
                                    ->where('customer_id', $customer_id)->first();
                            if($find_rating){
                                Session::put('rated_'.$product_id, $find_rating->rating_level);
                            }
                            break;
                        }
                    }
                }
            }
        }

        //Load rating and comment
        $get = 5;
        $all_rating = Rating::where('product_id',$product_id)->get();
        $all_comment = Comment::where('product_id',$product_id)
            ->orderBy('comment_useful','desc')->take($get)->get();
        $customers = DB::table('customer')
                ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                ->get();

        $all_rating_to_count = Rating::where('product_id',$product_id)->get();
        $all_comment_to_count = Comment::where('product_id',$product_id)
                            ->where('status',1)->get();
        $check_show = count($all_comment_to_count) - $get;

        //Count rating
        $rating_5 = count(Rating::where('product_id',$product_id)->where('rating_level', 5)->get());
        $rating_4 = count(Rating::where('product_id',$product_id)->where('rating_level', 4)->get());
        $rating_3 = count(Rating::where('product_id',$product_id)->where('rating_level', 3)->get());
        $rating_2 = count(Rating::where('product_id',$product_id)->where('rating_level', 2)->get());
        $rating_1 = count(Rating::where('product_id',$product_id)->where('rating_level', 1)->get());

        return view('client.home.product_detail',[
            'product'=>$product,
            'cate'=>$cate,
            'price'=>$price,
            'all_image'=>$all_image,
            'all_cart' => $all_cart,
            'wish_lish' => $wish_lish,
            'all_product'=>$all_product,
            'all_price' =>$all_price,
            'product_storage' => $product_storage,
            'all_rating' => $all_rating,
            'all_comment' => $all_comment,
            'customers' => $customers,
            'check_show' => $check_show,
            'all_rating_to_count' => $all_rating_to_count,
            'all_comment_to_count' => $all_comment_to_count,
            'rating_5' => $rating_5,
            'rating_4' => $rating_4,
            'rating_3' => $rating_3,
            'rating_2' => $rating_2,
            'rating_1' => $rating_1,
            'all_product_voucher' => $all_product_voucher,
            'storage_customer_voucher' => $storage_customer_voucher,
            'all_product_relate' => $all_product_relate,
        ]);
    }
    public function product_detail_slug($slug){
        $customer_id = Session::get('customer_id');
        $product = Product::where('slug',$slug)->first();
        $product_id = $product->product_id;
        $cate = Category::where('cate_id',$product->category_id)->first();
        $price = ProductPrice::where('product_id',$product_id)->where('status', 1)->first();
        $all_image = ImageProduct::where('product_id',$product_id)->get();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        $product_storage = Storage_Product::all();
        $all_product = Product::all();
        $all_price = ProductPrice::where('status',1)->get();

        $all_product_relate = DB::table('product')
        ->join('category','category.cate_id','=','product.category_id')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)
        ->get();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $all_product_voucher = Voucher::where('product_id', $product_id)
                                        ->where('status', 1)
                                        ->where('start_date', '<=' , $date_now)
                                        ->where('end_date', '>=', $date_now)
                                        ->where('voucher.voucher_quantity', '>', 0)
                                        ->get();
        $storage_customer_voucher = DB::table('storage_customer_voucher')
                                    ->join('voucher', 'voucher.voucher_id', '=', 'storage_customer_voucher.voucher_id')
                                    ->where('voucher.product_id', $product_id)
                                    ->where('customer_id', $customer_id)->get();

        // able rating and comment
        $orders = DB::table('order_detail_status')
                ->join('orders','orders.order_id','=','order_detail_status.order_id')
                ->where('status',1)->where('order_detail_status.status_id',4)
                ->where('customer_id', Session::get('customer_id'))->get();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if($orders){
            foreach ($orders as $order){
                $date_now = strtotime($now);
                $order_time = strtotime($order->create_at);
                $minus_date = abs($date_now - $order_time);
                $check_date = floor($minus_date / (60*60*24));
                if($check_date <= 30){
                    $order_item = Order_Item::where('order_id', $order->order_id)->get();
                    foreach ($order_item as $item){
                        if($item->product_id == $product_id){
                            Session::put('able_rating_comment_'.$product_id, $product_id);

                            $find_rating = Rating::where('product_id',$product_id)
                                    ->where('customer_id', $customer_id)->first();
                            if($find_rating){
                                Session::put('rated_'.$product_id, $find_rating->rating_level);
                            }
                            break;
                        }
                    }
                }
            }
        }

        //Load rating and comment
        $get = 5;
        $all_rating = Rating::where('product_id',$product_id)->get();
        $all_comment = Comment::where('product_id',$product_id)
            ->orderBy('comment_useful','desc')->take($get)->get();
        $customers = DB::table('customer')
                ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                ->get();

        $all_rating_to_count = Rating::where('product_id',$product_id)->get();
        $all_comment_to_count = Comment::where('product_id',$product_id)
                        ->where('status',1)->get();
        $check_show = count($all_comment_to_count) - $get;

        //Count rating
        $rating_5 = count(Rating::where('product_id',$product_id)->where('rating_level', 5)->get());
        $rating_4 = count(Rating::where('product_id',$product_id)->where('rating_level', 4)->get());
        $rating_3 = count(Rating::where('product_id',$product_id)->where('rating_level', 3)->get());
        $rating_2 = count(Rating::where('product_id',$product_id)->where('rating_level', 2)->get());
        $rating_1 = count(Rating::where('product_id',$product_id)->where('rating_level', 1)->get());

        return view('client.home.product_detail',[
            'product'=>$product,
            'cate'=>$cate,
            'price'=>$price,
            'all_image'=>$all_image,
            'all_cart' => $all_cart,
            'wish_lish' => $wish_lish,
            'all_product'=>$all_product,
            'all_price' =>$all_price,
            'product_storage' => $product_storage,
            'all_rating' => $all_rating,
            'all_comment' => $all_comment,
            'customers' => $customers,
            'check_show' => $check_show,
            'all_rating_to_count' => $all_rating_to_count,
            'all_comment_to_count' => $all_comment_to_count,
            'rating_5' => $rating_5,
            'rating_4' => $rating_4,
            'rating_3' => $rating_3,
            'rating_2' => $rating_2,
            'rating_1' => $rating_1,
            'all_product_voucher' => $all_product_voucher,
            'storage_customer_voucher' => $storage_customer_voucher,
            'all_product_relate' => $all_product_relate,
        ]);
    }
    public function load_detail_product(Request $request){
        $product_id = $request->product_id;

        $product = Product::find($product_id);
        $cate = Category::where('cate_id',$product->category_id)->first();
        $price = ProductPrice::where('product_id',$product_id)->where('status', 1)->first();
        $product_storage = Storage_Product::where('product_id',$product_id)->where('deleted_at', null)->first();

        echo view('client.home.mini_detail_product',[
            'product' =>$product,
            'cate' =>$cate,
            'price' =>$price,
            'product_storage' =>$product_storage,
        ]);
    }
    public function convert_day($month, $date){
        $num_day = 0;
        switch ($month) {
            case 1:
                $num_day = $date + $month*31;
                break;
            case 2:
                $num_day = $date + $month*28;
                break;
            case 3:
                $num_day = $date + $month*31;
                break;
            case 4:
                $num_day = $date + $month*30;
                break;
            case 5:
                $num_day = $date + $month*31;
                break;
            case 6:
                $num_day = $date + $month*30;
                break;
            case 7:
                $num_day = $date + $month*31;
                break;
            case 8:
                $num_day = $date + $month*31;
                break;
            case 9:
                $num_day = $date + $month*30;
                break;
            case 10:
                $num_day = $date + $month*31;
                break;
            case 11:
                $num_day = $date + $month*30;
                break;
            case 12:
                $num_day = $date + $month*31;
                break;
        }
        return $num_day;
    }

    public function add_comment_rating(Request $request){
        $number_rate = $request->number_rate;
        $comment_message = $request->comment_message;
        $product_id = $request->product_id;
        $customer_id = Session::get('customer_id');

        $find_rating = Rating::where('product_id',$product_id)
                    ->where('customer_id', $customer_id)->first();
        if($find_rating){
            Session::put('rated_'.$product_id, $number_rate);
        }
        else{
            $add_rating = new Rating();
            $add_rating->customer_id = $customer_id;
            $add_rating->product_id = $product_id;
            $add_rating->rating_level = $number_rate;
            $add_rating->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $result_add_rating = $add_rating->save();
            if($result_add_rating){
                Session::put('rated_'.$product_id, $number_rate);
            }
        }
        $add_comment = new Comment();
        $add_comment->customer_id = $customer_id;
        $add_comment->product_id = $product_id;
        $add_comment->comment_message = $comment_message;
        $add_comment->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $add_comment->save();

    }
    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $all_rating = Rating::where('product_id',$product_id)->get();
        $all_comment = Comment::where('product_id',$product_id)
            ->orderBy('comment_id','desc')->take(5)->get();
        $customers = DB::table('customer')
                ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                ->get();
        echo view('client.home.view_load_comment_ajax',[
            'all_rating'=> $all_rating,
            'all_comment'=> $all_comment,
            'customers'=> $customers,
            'product_id'=> $product_id,
        ]);
    }
    public function load_more_comment(Request $request){
        $val_add_more = $request->val_load_add;
        $product_id = $request->product_id;
        $all_rating = Rating::where('product_id',$product_id)
                ->orderBy('rating_id','desc')->get();
        $all_comment = Comment::where('product_id',$product_id)
                ->orderBy('comment_useful','desc')->take($val_add_more)->get();
        $customers = DB::table('customer')
                ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                ->get();
        $customer_info = Customer_Info::all();

        echo view('client.home.view_load_comment_ajax',[
            'all_rating'=> $all_rating,
            'all_comment'=> $all_comment,
            'customers'=> $customers,
            'customer_info'=> $customer_info,
        ]);
    }
    public function like_comment(Request $request){
        $comment_id = $request->comment_id;

        $session = Session::get('user_like_comment_'.$comment_id);
        if($session == $comment_id){
            $comment = Comment::find($comment_id);
            $count_comment_useful = $comment->comment_useful - 1;
            $comment->comment_useful = $count_comment_useful;
            $comment->save();
            Session::forget('user_like_comment_'.$comment_id);
        }
        else{
            $comment = Comment::find($comment_id);
            $count_comment_useful = $comment->comment_useful + 1;
            $comment->comment_useful = $count_comment_useful;
            $comment->save();
            Session::put('user_like_comment_'.$comment_id, $comment_id);
        }
        echo $count_comment_useful;
    }
    public function delete_comment(Request $request){
        $comment_id = $request->comment_id;

        $delete_comment = Comment::find($comment_id);
        $delete_comment->delete();

    }
    public function update_comment(Request $request){
        $comment_id = $request->comment_id;
        $comment_message = $request->comment_message;

        $update_comment = Comment::find($comment_id);
        $update_comment->comment_message = $comment_message;
        $update_comment->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $update_comment->save();
    }
    public function ajax_search_auto_complete(Request $request){
        $val_search_auto_complte = $request->val_search_auto_complte;
        $result_search = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->where('product_price.status', 1)
                        ->where('product_name','LIKE','%'.$val_search_auto_complte.'%')
                        ->get();
        echo view('client.home.view_search_auto_complete_ajax',['result_search'=>$result_search]);
    }
    public function search_product_form_search_auto_complete(Request $request){
        $val_search = $request->search_product;

        $customer_id = Session::get('customer_id');
        $all_product = Product::all();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();

        $all_category = Category::all();
        $result_search = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('category', 'category.cate_id', '=', 'product.category_id')
                        ->where('product_price.status', 1)
                        ->where('product_name','LIKE','%'.$val_search.'%')
                        ->get();
        return view('client.home.view_result_search',[
            'all_cart'=> $all_cart,
            'wish_lish'=> $wish_lish,
            'all_product'=> $all_product,
            'result_search'=> $result_search,
            'val_search'=> $val_search,
            'all_category'=> $all_category,
        ]);
    }
    public function contact_us(){
        $customer_id = Session::get('customer_id');
        $all_product = Product::all();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        return view('client.contact.contact_us',[
            'all_product'=>$all_product,
            'all_cart'=>$all_cart,
            'wish_lish'=> $wish_lish,
        ]);
    }
    public function terms_conditions(){
        $customer_id = Session::get('customer_id');
        $all_product = Product::all();
        $wish_lish = WishList::where('customer_id', $customer_id)->get();
        $all_cart = Cart::where('customer_id', $customer_id)->where('status', 1)->get();
        return view('client.terms_conditions.terms_conditions',[
            'all_product'=>$all_product,
            'all_cart'=>$all_cart,
            'wish_lish'=> $wish_lish,
        ]);
    }
    public function buy_now($product_id){
        $customer_id = Session::get('customer_id');

        $check_cart = Cart::where('customer_id', $customer_id)->where('product_id',$product_id)->first();
        if($check_cart){
            $update_cart = Cart::where('customer_id', $customer_id)->where('product_id',$product_id)->first();
            $update_cart->quantity = $update_cart->quantity + 1;
            $update_cart->save();
        }
        else{
            $add_cart = new Cart();
            $add_cart->product_id = $product_id;
            $add_cart->customer_id = $customer_id;
            $add_cart->quantity = 1;
            $add_cart->save();
        }
        return redirect('show_cart');

    }
}
