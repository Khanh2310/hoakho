<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductPrice;
use App\Storage_Product;
use App\Discount;
use App\History_Discount;
use App\Admin_Action_Discount;
use App\Admin;
use DB;
use Session;
use Carbon\Carbon;
use PDF;
class DiscountController extends Controller
{
    public function all_discount(){
        $all_discount = Discount::orderBy('discount_id','desc')->get();
        $all_product = Product::all();
        return view('admin.discount.all_discount',[
            'all_product'=> $all_product,
            'all_discount'=> $all_discount
        ]);
    }
    public function add_discount(){
        $all_product = DB::table('product')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product_price.status',1)->where('product.discount_id', null)
        ->where('product.deleted_at', null)->get();
        return view('admin.discount.add_discount',['products'=>$all_product]);
    }
    public function check_val_discount(Request $request){
        $time_start_1 = $request->time_start_1;
        $time_end_1 = $request->time_end_1;
        $condition_discount_1 = $request->condition_discount_1;
        $amount_discount_1 = $request->amount_discount_1;
        $arrProduct = $request->arrCheck;
        $arrPrice = array();

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if(date('Y-m-d\TH:i', strtotime($now)) > date('Y-m-d\TH:i', strtotime($time_start_1)) ||
            date('Y-m-d\TH:i', strtotime($time_start_1)) > date('Y-m-d\TH:i', strtotime($time_end_1)) ||
             date('Y-m-d\TH:i', strtotime($time_end_1)) < date('Y-m-d\TH:i', strtotime($now)) ||
              date('Y-m-d\TH:i', strtotime($time_start_1)) == date('Y-m-d\TH:i', strtotime($time_end_1))){
            echo 1;
        }
        else{
            if($condition_discount_1 == 1){
                if($amount_discount_1 >= 100 || $amount_discount_1 < 0){
                    echo 2;
                }
                else{
                    echo 3;
                }
            }else{
                if(count($arrProduct) > 0){
                    foreach ($arrProduct as $prod_name){
                        //$product = Product::where('product_name',$prod_name)->first();
                        $product = DB::table('product')
                        ->join('product_price','product_price.product_id','=','product.product_id')
                        ->where('product_name', $prod_name)->where('status',1)->first();
                        array_push($arrPrice, $product->price);
                    }
                    sort($arrPrice);
                    echo $arrPrice[0];
                }
                else{
                    echo 3;
                }

            }
        }
    }
    public function check_val_discount_2(Request $request){
        $time_start_2 = $request->time_start_2;
        $time_end_2 = $request->time_end_2;
        $condition_discount_2 = $request->condition_discount_2;
        $amount_discount_2 = $request->amount_discount_2;
        $arrProduct = $request->arrCheck;
        $arrPrice = array();
        if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            if(date('Y-m-d\TH:i', strtotime($now)) > date('Y-m-d\TH:i', strtotime($time_start_2)) ||
                date('Y-m-d\TH:i', strtotime($time_start_2)) > date('Y-m-d\TH:i', strtotime($time_end_2)) ||
                date('Y-m-d\TH:i', strtotime($time_end_2)) < date('Y-m-d\TH:i', strtotime($now)) ||
                date('Y-m-d\TH:i', strtotime($time_start_2)) == date('Y-m-d\TH:i', strtotime($time_end_2))){
                echo 1;
            }
            else{
                if($condition_discount_2 == 1){
                    if($amount_discount_2 >= 100 || $amount_discount_2 < 0){
                        echo 2;
                    }
                    else{
                        echo 3;
                    }
                }else{
                    if(count($arrProduct) > 0){
                        foreach ($arrProduct as $prod_name){
                            //$product = Product::where('product_name',$prod_name)->first();
                            $product = DB::table('product')
                            ->join('product_price','product_price.product_id','=','product.product_id')
                            ->where('product_name', $prod_name)->where('status',1)->first();
                            array_push($arrPrice, $product->price);
                        }
                        sort($arrPrice);
                        echo $arrPrice[0];
                    }
                    else{
                        echo 3;
                    }

                }
            }
        }
        else{
            echo 3;
        }

    }
    public function check_val_discount_update(Request $request){
        $time_start_1 = $request->time_start_1;
        $time_end_1 = $request->time_end_1;
        $condition_discount_1 = $request->condition_discount_1;
        $amount_discount_1 = $request->amount_discount_1;
        $discount_id = $request->discount_id;
        if($request->arrCheck){
            $arrProduct = $request->arrCheck;
        }
        else{
            $arrProduct = array();
        }
        $arrPrice = array();

        $old_discount_1 = Discount::find($discount_id);
        if(
            date('Y-m-d\TH:i', strtotime($time_start_1)) == date('Y-m-d\TH:i', strtotime($old_discount_1->start_date_1)) &&
            date('Y-m-d\TH:i', strtotime($time_end_1)) == date('Y-m-d\TH:i', strtotime($old_discount_1->end_date_1)) &&
            $condition_discount_1 == $old_discount_1->condition_discount_1 &&
            $amount_discount_1 == $old_discount_1->amount_discount_1
            ){
                echo 3;
            }
        else{
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            if(date('Y-m-d\TH:i', strtotime($now)) > date('Y-m-d\TH:i', strtotime($time_start_1)) ||
                date('Y-m-d\TH:i', strtotime($time_start_1)) > date('Y-m-d\TH:i', strtotime($time_end_1)) ||
                date('Y-m-d\TH:i', strtotime($time_end_1)) < date('Y-m-d\TH:i', strtotime($now)) ||
                date('Y-m-d\TH:i', strtotime($time_start_1)) == date('Y-m-d\TH:i', strtotime($time_end_1))){
                echo 1;
            }
            else{
                if($condition_discount_1 == 1){
                    if($amount_discount_1 >= 100 || $amount_discount_1 < 0){
                        echo 2;
                    }
                    else{
                        echo 3;
                    }
                }else{
                    if(count($arrProduct) > 0){
                        foreach ($arrProduct as $prod_name){
                            //$product = Product::where('product_name',$prod_name)->first();
                            $product = DB::table('product')
                            ->join('product_price','product_price.product_id','=','product.product_id')
                            ->where('product_name', $prod_name)->where('status',1)->first();
                            array_push($arrPrice, $product->price);
                        }
                        sort($arrPrice);
                        echo $arrPrice[0];
                    }
                    else{
                        echo 3;
                    }

                }
            }
        }

    }
    public function check_val_discount_update_2(Request $request){
        $time_start_2 = $request->time_start_2;
        $time_end_2 = $request->time_end_2;
        $condition_discount_2 = $request->condition_discount_2;
        $amount_discount_2 = $request->amount_discount_2;
        if($request->arrCheck){
            $arrProduct = $request->arrCheck;
        }
        else{
            $arrProduct = array();
        }
        $arrPrice = array();
        $discount_id = $request->discount_id;
        if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
            $old_discount_2 = Discount::find($discount_id);
            if(
                date('Y-m-d\TH:i', strtotime($time_start_2)) == date('Y-m-d\TH:i', strtotime($old_discount_2->start_date_2)) &&
                date('Y-m-d\TH:i', strtotime($time_end_2)) == date('Y-m-d\TH:i', strtotime($old_discount_2->end_date_2)) &&
                $condition_discount_2 == $old_discount_2->condition_discount_2 &&
                $amount_discount_2 == $old_discount_2->amount_discount_2
                ){
                    echo 3;
                }
            else{
                $now = Carbon::now('Asia/Ho_Chi_Minh');
                if(date('Y-m-d\TH:i', strtotime($now)) > date('Y-m-d\TH:i', strtotime($time_start_2)) ||
                    date('Y-m-d\TH:i', strtotime($time_start_2)) > date('Y-m-d\TH:i', strtotime($time_end_2)) ||
                    date('Y-m-d\TH:i', strtotime($time_end_2)) < date('Y-m-d\TH:i', strtotime($now)) ||
                    date('Y-m-d\TH:i', strtotime($time_start_2)) == date('Y-m-d\TH:i', strtotime($time_end_2))){
                    echo 1;
                }
                else{
                    if($condition_discount_2 == 1){
                        if($amount_discount_2 >= 100 || $amount_discount_2 < 0){
                            echo 2;
                        }
                        else{
                            echo 3;
                        }
                    }else{
                        if(count($arrProduct) > 0){
                            foreach ($arrProduct as $prod_name){
                                //$product = Product::where('product_name',$prod_name)->first();
                                $product = DB::table('product')
                                ->join('product_price','product_price.product_id','=','product.product_id')
                                ->where('product_name', $prod_name)->where('status',1)->first();
                                array_push($arrPrice, $product->price);
                            }
                            sort($arrPrice);
                            echo $arrPrice[0];
                        }
                        else{
                            $all_product_discount = Product::where('discount_id',$discount_id)->get();
                            foreach ($all_product_discount as $product_discount) {
                                $product = DB::table('product')
                                ->join('product_price','product_price.product_id','=','product.product_id')
                                ->where('product.product_id', $product_discount->product_id)->where('status',1)->first();
                                array_push($arrPrice, $product->price);
                            }
                            sort($arrPrice);
                            echo $arrPrice[0];
                        }

                    }
                }
            }
        }
        else{
            echo 3;
        }

    }
    public function process_add_discount(Request $request){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $time_start_1 = $request->time_start_1;
        $time_end_1 = $request->time_end_1;
        $condition_discount_1 = $request->condition_discount_1;
        $amount_discount_1 = $request->amount_discount_1;

        $time_start_2 = $request->time_start_2;
        $time_end_2 = $request->time_end_2;
        $condition_discount_2 = $request->condition_discount_2;
        $amount_discount_2 = $request->amount_discount_2;
        $list_product_discount = $request->list_product_discount;

        $add_discount = new Discount();
        $add_discount->start_date_1 = $time_start_1;
        $add_discount->end_date_1 = $time_end_1;
        $add_discount->amount_discount_1 = $amount_discount_1;
        $add_discount->condition_discount_1 = $condition_discount_1;
        if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
            $add_discount->start_date_2 = $time_start_2;
            $add_discount->end_date_2 = $time_end_2;
            $add_discount->amount_discount_2 = $amount_discount_2;
            $add_discount->condition_discount_2 = $condition_discount_2;
        }
        $result_add_discount = $add_discount->save();
        if($result_add_discount){
            $arrProduct = explode(",", $list_product_discount);
            foreach ($arrProduct as $prod){
                $product = Product::where('product_name',$prod)->first();
                if($product){
                    //update discount product
                    $update_product = Product::find($product->product_id);
                    $update_product->discount_id = $add_discount->discount_id;
                    $update_product->save();

                    // add history discount
                    $add_history_discount = new History_Discount();
                    $add_history_discount->product_id = $product->product_id;
                    $add_history_discount->start_date_1 = $time_start_1;
                    $add_history_discount->end_date_1 = $time_end_1;
                    $add_history_discount->amount_discount_1 = $amount_discount_1;
                    $add_history_discount->condition_discount_1 = $condition_discount_1;
                    if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
                        $add_history_discount->start_date_2 = $time_start_2;
                        $add_history_discount->end_date_2 = $time_end_2;
                        $add_history_discount->amount_discount_2 = $amount_discount_2;
                        $add_history_discount->condition_discount_2 = $condition_discount_2;
                    }
                    $add_history_discount->discount_id = $add_discount->discount_id;
                    $add_history_discount->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $add_history_discount->save();
                }


            }
            // add admin action
            $admin_action_discount = new Admin_Action_Discount();
            $admin_action_discount->admin_id = Session::get('admin_id');
            $admin_action_discount->discount_id = $add_discount->discount_id;
            $admin_action_discount->action_id = 1;
            $admin_action_discount->action_message = 'Thêm giảm giá';
            $admin_action_discount->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_discount->save();

            $request->session()->flash('add_discount_success', 'Thêm giảm giá sản phẩm thành công');
            return redirect('admin/all_discount');
        }
    }
    public function update_discount($discount_id){
        $discount = Discount::find($discount_id);
        $products = Product::where('discount_id',$discount_id)->get();
        $all_product = DB::table('product')
        ->join('product_price','product_price.product_id','=','product.product_id')
        ->join('storage_product','storage_product.product_id','=','product.product_id')
        ->where('product.deleted_at', null)
        ->where('product_price.status',1)->get();
        return view('admin.discount.update_discount',[
            'discount'=> $discount,
            'products'=> $products,
            'all_product'=> $all_product,
        ]);
    }
    public function process_update_discount(Request $request, $discount_id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $time_start_1 = $request->time_start_1;
        $time_end_1 = $request->time_end_1;
        $condition_discount_1 = $request->condition_discount_1;
        $amount_discount_1 = $request->amount_discount_1;

        $time_start_2 = $request->time_start_2;
        $time_end_2 = $request->time_end_2;
        $condition_discount_2 = $request->condition_discount_2;
        $amount_discount_2 = $request->amount_discount_2;
        $list_product_discount = $request->list_product_discount;
        if($list_product_discount != ''){
            $arrProduct = explode(",", $list_product_discount);
        }
        else{
            $arrProduct = array();
        }
        if(count($arrProduct) > 0){
            $old_products = Product::where('discount_id', $discount_id)->where('deleted_at', null)->get();
            foreach ($old_products as $old_prod){
                $update_old_discount_product = Product::find($old_prod->product_id);
                $update_old_discount_product->discount_id = null;
                $update_old_discount_product->save();
            }
        }
        $update_discount =Discount::find($discount_id);
        $update_discount->start_date_1 = $time_start_1;
        $update_discount->end_date_1 = $time_end_1;
        $update_discount->amount_discount_1 = $amount_discount_1;
        $update_discount->condition_discount_1 = $condition_discount_1;
        if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
            $update_discount->start_date_2 = $time_start_2;
            $update_discount->end_date_2 = $time_end_2;
            $update_discount->amount_discount_2 = $amount_discount_2;
            $update_discount->condition_discount_2 = $condition_discount_2;
        }
        $result_update_discount = $update_discount->save();
        if($result_update_discount){
            if(count($arrProduct) > 0){
                foreach ($arrProduct as $prod){
                    $product = Product::where('product_name',$prod)->first();
                    if($product){
                        //update new discount product
                        $update_new_discount_product = Product::find($product->product_id);
                        $update_new_discount_product->discount_id = $update_discount->discount_id;
                        $update_new_discount_product->save();

                        // add history discount
                        $add_history_discount = new History_Discount();
                        $add_history_discount->product_id = $product->product_id;
                        $add_history_discount->start_date_1 = $time_start_1;
                        $add_history_discount->end_date_1 = $time_end_1;
                        $add_history_discount->amount_discount_1 = $amount_discount_1;
                        $add_history_discount->condition_discount_1 = $condition_discount_1;
                        if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
                            $add_history_discount->start_date_2 = $time_start_2;
                            $add_history_discount->end_date_2 = $time_end_2;
                            $add_history_discount->amount_discount_2 = $amount_discount_2;
                            $add_history_discount->condition_discount_2 = $condition_discount_2;
                        }
                        $add_history_discount->discount_id = $discount_id;
                        $add_history_discount->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                        $add_history_discount->save();
                    }

                }
            }
            else{
                $find_all_product = Product::where('discount_id',$discount_id)->get();
                foreach($find_all_product as $find_product){
                    //update new discount product
                    $update_new_discount_product = Product::find($find_product->product_id);
                    $update_new_discount_product->discount_id = $discount_id;
                    $update_new_discount_product->save();

                    // add history discount
                    $add_history_discount = new History_Discount();
                    $add_history_discount->product_id = $find_product->product_id;
                    $add_history_discount->start_date_1 = $time_start_1;
                    $add_history_discount->end_date_1 = $time_end_1;
                    $add_history_discount->amount_discount_1 = $amount_discount_1;
                    $add_history_discount->condition_discount_1 = $condition_discount_1;
                    if($time_start_2 != '' && $time_end_2 != '' && $condition_discount_2 != '' && $amount_discount_2 != ''){
                        $add_history_discount->start_date_2 = $time_start_2;
                        $add_history_discount->end_date_2 = $time_end_2;
                        $add_history_discount->amount_discount_2 = $amount_discount_2;
                        $add_history_discount->condition_discount_2 = $condition_discount_2;
                    }
                    $add_history_discount->discount_id = $discount_id;
                    $add_history_discount->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $add_history_discount->save();
                }
            }
            // add admin action
            $admin_action_discount = new Admin_Action_Discount();
            $admin_action_discount->admin_id = Session::get('admin_id');
            $admin_action_discount->discount_id = $discount_id;
            $admin_action_discount->action_id = 2;
            $admin_action_discount->action_message = 'Thiết lập lại giảm giá';
            $admin_action_discount->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_discount->save();

            $request->session()->flash('update_discount_success', 'Thiết lập lại giảm giá sản phẩm thành công');
            return redirect()->back();
        }
    }
    public function detail_discount($discount_id){
        $all_product = DB::table('product')
                    ->join('product_price','product_price.product_id','=','product.product_id')
                    ->join('storage_product','storage_product.product_id','=','product.product_id')
                    ->where('product_price.status',1)->where('product.discount_id', $discount_id)
                    ->where('product.deleted_at', null)->get();
        $discount = Discount::find($discount_id);
        $all_admin = Admin::all();

        $time_line_his = Admin_Action_Discount::where('discount_id', $discount_id)->orderBy('action_time','desc')->get();
        $history_discount = History_Discount::where('discount_id',$discount_id)->get();
        $all_product_history_discount = DB::table('product')->get();
        return view('admin.discount.detail_discount',[
            'all_product'=>$all_product,
            'discount'=>$discount,
            'time_line_his'=>$time_line_his,
            'history_discount'=>$history_discount,
            'all_product_history_discount'=>$all_product_history_discount,

            'all_admin'=>$all_admin,
        ]);
    }
    public function delete_discount(Request $request){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $discount_id = $request->discount_id;

        $all_product = Product::where('discount_id',$discount_id)->get();
        foreach($all_product as $product){
            $update_product = Product::find($product->product_id);
            $update_product->discount_id = null;
            $update_product->save();
        }
        //delete discount
        $delete_discount = Discount::find($discount_id);
        $delete_discount->delete();

        //delete history discount
        $all_his_discount = History_Discount::all();
        foreach ($all_his_discount as $all_his){
            if($all_his->discount_id == $discount_id){
                $delete_his_discount = History_Discount::where('discount_id',$discount_id);
                $delete_his_discount->delete();
            }
        }

        // admin action
            $admin_action_discount = new Admin_Action_Discount();
            $admin_action_discount->admin_id = Session::get('admin_id');
            $admin_action_discount->discount_id = $discount_id;
            $admin_action_discount->action_id = 2;
            $admin_action_discount->action_message = 'Xóa giảm giá';
            $admin_action_discount->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_discount->save();

        $request->session()->flash('delete_discount_success', 'Xóa giảm giá thành công');
        return redirect('admin/all_discount');
    }
    public function delete_discount_when_filter(Request $request, $discount_id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $all_product = Product::where('discount_id',$discount_id)->get();
        foreach($all_product as $product){
            $update_product = Product::find($product->product_id);
            $update_product->discount_id = null;
            $update_product->save();
        }
        //delete discount
        $delete_discount = Discount::find($discount_id);
        $delete_discount->delete();

        //delete history discount
        $all_his_discount = History_Discount::all();
        foreach ($all_his_discount as $all_his){
            if($all_his->discount_id == $discount_id){
                $delete_his_discount = History_Discount::where('discount_id',$discount_id);
                $delete_his_discount->delete();
            }
        }

        // admin action
            $admin_action_discount = new Admin_Action_Discount();
            $admin_action_discount->admin_id = Session::get('admin_id');
            $admin_action_discount->discount_id = $discount_id;
            $admin_action_discount->action_id = 2;
            $admin_action_discount->action_message = 'Xóa giảm giá';
            $admin_action_discount->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_discount->save();

        $request->session()->flash('delete_discount_success', 'Xóa giảm giá thành công');
        return redirect('admin/all_discount');
    }

    public function filter_discount_status_time_discount(Request $request){
        $status_time = $request->status_time;

        $type_filter = 'time_discount';
        $level_filter = $status_time;

        $now = Carbon::now('Asia/Ho_Chi_Minh');

        $all_discount_get = Discount::all();
        $all_product = Product::all();

        if($status_time == 1){
            $arrDiscount = array();
            $string_title = 'Danh Sách Giảm Giá Còn Thời Hạn';

            foreach($all_discount_get as $discount){
                if($now <= $discount->end_date_2 || $now <= $discount->end_date_1){
                    $arrDiscount[] = $discount;
                }
            }
            $all_discount = $arrDiscount;
        }
        else{
            $arrDiscount = array();
            $string_title = 'Danh Sách Giảm Giá Hết Thời Hạn';

            foreach($all_discount_get as $discount){
                if($now > $discount->end_date_2 &&  $now > $discount->end_date_1){
                    $arrDiscount[] = $discount;
                }
            }
            $all_discount = $arrDiscount;
        }

        echo view('admin.discount.view_filter_discount',[
            'all_product'=> $all_product,
            'all_discount'=> $all_discount,
            'string_title'=> $string_title,
            'type_filter'=> $type_filter,
            'level_filter'=> $level_filter,
        ]);
    }

    public function print_pdf_discount(Request $request){
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $all_discount_get = Discount::all();
        $all_product = Product::all();

        switch ($type_filter) {
            case 'time_discount':
                if($level_filter == 1){
                    $arrDiscount = array();
                    $string_title = 'Danh Sách Giảm Giá Còn Thời Hạn';

                    foreach($all_discount_get as $discount){
                        if($now <= $discount->end_date_2 || $now <= $discount->end_date_1){
                            $arrDiscount[] = $discount;
                        }
                    }
                    $all_discount = $arrDiscount;

                    $pdf = PDF::loadView('admin.discount.view_print_pdf_discount', [
                        'all_discount'=>$all_discount,
                        'string_title'=>$string_title,
                        'all_product'=>$all_product,
                    ]);
                    return $pdf->download('list_discount_still_time.pdf');
                }
                else{
                    $arrDiscount = array();
                    $string_title = 'Danh Sách Giảm Giá Hết Thời Hạn';

                    foreach($all_discount_get as $discount){
                        if($now > $discount->end_date_2 &&  $now > $discount->end_date_1){
                            $arrDiscount[] = $discount;
                        }
                    }
                    $all_discount = $arrDiscount;
                    $pdf = PDF::loadView('admin.discount.view_print_pdf_discount', [
                        'all_discount'=>$all_discount,
                        'string_title'=>$string_title,
                        'all_product'=>$all_product,
                    ]);
                    return $pdf->download('list_discount_out_of_time.pdf');
                }
                break;
            default:
                $string_title = 'Danh Sách Giảm Giá';
                $pdf = PDF::loadView('admin.discount.view_print_pdf_discount', [
                    'all_discount'=>$all_discount_get,
                    'string_title'=>$string_title,
                    'all_product'=>$all_product,
                ]);
                return $pdf->download('list_discount.pdf');
        }
    }

}
