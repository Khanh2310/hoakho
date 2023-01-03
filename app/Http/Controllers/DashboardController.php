<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Support\Collection;
use App\Support\Collection;

use Illuminate\Http\Request;
use App\Order_Detail_Status;
use App\Orders;
use App\Customer;
use App\Product;
use App\Admin;
use App\Category;
use App\Storage;
use App\Slider;
use App\Voucher;
use DB;
use PDF;


class DashboardController extends Controller
{
    public function index(){

        $arrSaled = [];
        $arrOrder = [];
        $arrRevenue = [];
        $arrCustomerBestBuy = [];
        $arrProductBestRating = [];
        $arrProductBestSaled = [];
        $topCustomerBuy = [];
        $topProductRating = [];
        $topProductSaled = [];

        $callFunction = new HomeClientController;

        $all_customer = DB::table('customer')
                        ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                        ->get();
        $all_order = DB::table('orders')
                    ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                    ->where('order_detail_status.status', 1)
                    ->get();
        $all_product = Product::all();
        $all_category = Category::all();
        $all_storage = Storage::all();
        $all_slider = Slider::where('slider_status', 1)->get();
        $all_voucher = Voucher::all();
        $revenue = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->sum('total_price');
        $all_admin = Admin::all();
        // list top customer
        foreach ($all_customer as $customer){
            $number_buy = $this->CountBuyCustomer($customer->customer_id);
            if($number_buy > 0){
                $customer->all_product_buy = $number_buy;
                $arrCustomerBestBuy[] = $customer;
            }
        }
        $listCustomerBuy = collect($arrCustomerBestBuy)->sortBy('all_product_buy')->reverse()->toArray();
        $topCustomerBuy = array_slice($listCustomerBuy, 0, 5);

        //list top rating product
        foreach ($all_product as $product){
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            if($check_rating->avg_rating >= 3){
                $product->avg_rating = $check_rating->avg_rating;
                $arrProductBestRating[] = $product;
            }
        }
        $listProductRating = collect($arrProductBestRating)->sortBy('avg_rating')->reverse()->toArray();
        $topProductRating = array_slice($listProductRating, 0, 4);

        //list top saled product
        foreach ($all_product as $product){
            $check_saled = $callFunction->info_rating_saled($product->product_id);
            if($check_saled->count_product_saled >= 1){
                $product->count_product_saled = $check_saled->count_product_saled;
                $arrProductBestSaled[] = $product;
            }
        }
        $listProductSaled = collect($arrProductBestSaled)->sortBy('count_product_saled')->reverse()->toArray();
        $topProductSaled = array_slice($listProductSaled, 0, 4);

        $year = date("Y", strtotime(date('Y')));
        for($i = 1; $i <=12; $i++){
            $arrSaled[] = $this->StatisticalSaled($i,$year);
            $arrOrder[] = $this->StatisticalOrder($i,$year);
            $arrRevenue[] = $this->StatisticalRevenue($i,$year);
        }
        $total_revenue_year = number_format($this->StatisticalRevenueYear($year), 0, ',', '.').'₫';

        $statisticals_daily = $this->RevenueOrderDaily();

        return view('admin.dashboard.dashbord',[
            'arrSaled' => $arrSaled,
            'arrRevenue' => $arrRevenue,
            'arrOrder' => $arrOrder,
            'year' => $year,

            'all_customer' => $all_customer,
            'all_order' => $all_order,
            'all_product' => $all_product,
            'all_admin' => $all_admin,
            'all_category' => $all_category,
            'all_storage' => $all_storage,
            'all_slider' => $all_slider,
            'all_voucher' => $all_voucher,
            'revenue' => $revenue,

            'topCustomerBuy' => $topCustomerBuy,
            'topProductRating' => $topProductRating,
            'topProductSaled' => $topProductSaled,

            'statisticals_daily' => $statisticals_daily,

            'total_revenue_year' => $total_revenue_year
        ]);
    }
    public static function StatisticalSaled($month, $year){
        $orders = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->whereYear('orders.create_at', $year)
                ->whereMonth('orders.create_at',$month)
                ->get();
        return count($orders);
    }
    public static function StatisticalOrder($month, $year){
        $orders = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status', 1)
                ->whereYear('orders.create_at', $year)
                ->whereMonth('orders.create_at',$month)
                ->get();
        return count($orders);
    }
    public static function StatisticalRevenue($month, $year){
        $orders = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->whereYear('orders.create_at', $year)
                ->whereMonth('orders.create_at',$month)
                ->sum('total_price');
        return $orders;
    }
    public static function StatisticalRevenueYear($year){
        $orders = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->whereYear('orders.create_at', $year)
                ->sum('total_price');
        return $orders;
    }
    public static function CountBuyCustomer($customer_id){
        $count_buy = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->join('order_item','order_item.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->where('orders.customer_id',$customer_id)
                ->sum('order_item.quantity_product');
        return $count_buy;
    }
    public function filer_year_order_dashboard(Request $request){
        $year = $request->year;
        $arrContent = [];
        $arrSaled = [];
        $arrOrder = [];
        for($i = 1; $i <=12; $i++){
            $arrSaled[] = $this->StatisticalSaled($i,$year);
            $arrOrder[] = $this->StatisticalOrder($i,$year);
        }
        $arrContent = [
            $arrSaled,
            $arrOrder
        ];

        return $arrContent;
    }
    public function filer_year_revenue_dashboard(Request $request){
        $year = $request->year;
        $arrRevenue = array();

        for($i = 1; $i <=12; $i++){
            $arrRevenue[0][] = $this->StatisticalRevenue($i,$year);
        }
        $arrRevenue[1][] = number_format($this->StatisticalRevenueYear($year), 0, ',', '.').'₫';
        return $arrRevenue;
    }
    public static function NotificationsOrder(){
        $notification = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->join('customer','customer.customer_id', '=', 'orders.customer_id')
                ->join('customer_info','customer_info.customer_id', '=', 'customer.customer_id')
                ->where('order_detail_status.status_id', 1)
                ->where('order_detail_status.status', 1)
                ->orderBy('orders.order_id','desc')
                ->get();
        return $notification;
    }
    public static function RevenueOrderDaily(){
        // get list date
        $order_date = array();
        $obStatistical = [];
        $statistical_order = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->orderBy('create_at', 'Asc')
                        ->get();
        foreach ($statistical_order as $order){
            $order_date[] = date('Y-m-d', strtotime($order->create_at));
        }
        $unique_date = array_unique($order_date);
        foreach ($unique_date as $date){
            $count_order = Orders::whereDate('create_at', $date)->get();
            $total_receive = Orders::whereDate('create_at',$date)->sum('total_price');
            $arrMege = [
                'count_order' => count($count_order),
                'total_receive' => $total_receive,
                'date' => $date,
            ];
            $obStatistical[] = $arrMege;
        }
        // dd($obStatistical);
        $data = (new Collection($obStatistical))->paginate(5);
        return $data;
    }
    public function print_pdf_dashbpard_revenue_daily(Request $request){
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $order_date = array();
        $obStatistical = [];
        $string_title = '';

        if($date_start == '' && $date_end == ''){
            $statistical_order = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->orderBy('create_at', 'Asc')
                        ->get();
            $string_title = 'Thống Kê Doanh Thu';
            $revenue = DB::table('orders')
                ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                ->where('order_detail_status.status_id', 4)
                ->sum('total_price');
        }else{
            $statistical_order = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->whereDate('orders.create_at','>=', $date_start)
                        ->whereDate('orders.create_at','<=', $date_end)
                        ->orderBy('create_at', 'Asc')
                        ->get();
            $revenue = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->whereDate('orders.create_at','>=', $date_start)
                        ->whereDate('orders.create_at','<=', $date_end)
                        ->sum('total_price');
            $string_title = 'Thống Kê Doanh Thu từ ngày '
                                .date('d/m/Y', strtotime($date_start)).' - '
                                .date('d/m/Y', strtotime($date_end));
        }
        if(count($statistical_order)>0){
            foreach ($statistical_order as $order){
                $order_date[] = date('Y-m-d', strtotime($order->create_at));
            }
            $unique_date = array_unique($order_date);
            foreach ($unique_date as $date){
                $count_order = Orders::whereDate('create_at', $date)->get();
                $total_receive = Orders::whereDate('create_at',$date)->sum('total_price');
                $arrMege = [
                    'count_order' => count($count_order),
                    'total_receive' => $total_receive,
                    'date' => $date,
                ];
                $obStatistical[] = $arrMege;
            }
        }

        $data = $obStatistical;
        $pdf = PDF::loadView('admin.dashboard.view_print_pdf_revenue_daily_order', [
            'data'=>$data,
            'string_title'=>$string_title,
            'revenue'=>$revenue,
        ]);
        return $pdf->download('thongkedoanhthumoingay.pdf');
    }
    public function filter_date_daily_order(Request $request){
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $order_date = array();
        $obStatistical = [];
        $statistical_order = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->whereDate('orders.create_at','>=', $date_start)
                        ->whereDate('orders.create_at','<=', $date_end)
                        ->orderBy('create_at', 'Asc')
                        ->get();
        $string_title = 'Thống Kê Doanh Thu từ ngày '
                        .date('d/m/Y', strtotime($date_start)).' - '
                        .date('d/m/Y', strtotime($date_end));
        $revenue = DB::table('orders')
                        ->join('order_detail_status','order_detail_status.order_id','=','orders.order_id')
                        ->where('order_detail_status.status_id', 4)
                        ->whereDate('orders.create_at','>=', $date_start)
                        ->whereDate('orders.create_at','<=', $date_end)
                        ->sum('total_price');
        if(count($statistical_order)>0){
            foreach ($statistical_order as $order){
                $order_date[] = date('Y-m-d', strtotime($order->create_at));
            }
            $unique_date = array_unique($order_date);
            foreach ($unique_date as $date){
                $count_order = Orders::whereDate('create_at', $date)->get();
                $total_receive = Orders::whereDate('create_at',$date)->sum('total_price');
                $arrMege = [
                    'count_order' => count($count_order),
                    'total_receive' => $total_receive,
                    'date' => $date,
                ];
                $obStatistical[] = $arrMege;
            }
        }
        $data = $obStatistical;
        return view('admin.dashboard.view_filter_daily_order',[
            'string_title'=>$string_title,
            'statisticals_daily'=>$data,
            'revenue'=>$revenue,
            'date_start'=>$date_start,
            'date_end'=>$date_end,
        ]);
    }
}
