<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Unit;
use App\Storage;
use App\Product;
use App\ProductPrice;
use App\Storage_Product;
use App\ImageProduct;
use App\Admin;
use App\Admin_Action_Storage_Product;
use App\Admin_Action_Product;
use App\Admin_Action_Product_Price;
use App\Comment;
use Session;
use DB;
use Carbon\Carbon;
use PDF;
use Str;

class TraceSideProfileController extends Controller
{
    // trace_side_profile
    public function trace_product_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.action_id', $type_action)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.product_id', $product_id)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.product_id', $product_id)
                                ->where('admin_action_product.action_id', $type_action)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_product_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào sản phẩm từ ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date))
                            ;
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào sản phẩm từ ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date))
                            .' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.action_id', $type_action)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào sản phẩm "'.$product->product_name.'" từ ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.product_id', $product_id)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product')
                                ->join('product','product.product_id','=','admin_action_product.product_id')
                                ->join('action','action.action_id','=','admin_action_product.action_id')
                                ->where('admin_action_product.admin_id', $admin_id)
                                ->where('admin_action_product.product_id', $product_id)
                                ->where('admin_action_product.action_id', $type_action)
                                ->orderBy('admin_action_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_cate_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $cate_id = $request->cate_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($cate_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào danh mục sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào danh mục sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->where('admin_action_category.action_id', $type_action)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $cate = Category::find($cate_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào danh mục "'.$cate->cate_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->where('admin_action_category.cate_id', $cate_id)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào danh mục "'.$cate->cate_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_category')
                            ->join('category','category.cate_id','=','admin_action_category.cate_id')
                            ->join('action','action.action_id','=','admin_action_category.action_id')
                            ->where('admin_action_category.admin_id', $admin_id)
                            ->where('admin_action_category.action_id', $type_action)
                            ->where('admin_action_category.cate_id', $cate_id)
                            ->orderBy('admin_action_category.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_cate_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $cate_id = $request->cate_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($cate_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào danh mục sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào danh mục sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).
                            ' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->where('admin_action_category.action_id', $type_action)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $cate = Category::find($cate_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào danh mục "'.$cate->cate_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_category')
                                ->join('category','category.cate_id','=','admin_action_category.cate_id')
                                ->join('action','action.action_id','=','admin_action_category.action_id')
                                ->where('admin_action_category.admin_id', $admin_id)
                                ->where('admin_action_category.cate_id', $cate_id)
                                ->orderBy('admin_action_category.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào danh mục "'.$cate->cate_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_category')
                            ->join('category','category.cate_id','=','admin_action_category.cate_id')
                            ->join('action','action.action_id','=','admin_action_category.action_id')
                            ->where('admin_action_category.admin_id', $admin_id)
                            ->where('admin_action_category.action_id', $type_action)
                            ->where('admin_action_category.cate_id', $cate_id)
                            ->orderBy('admin_action_category.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->cate_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_price_product_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_product_price')
                                ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                                ->join('product','product.product_id','=','product_price.product_id')
                                ->join('action','action.action_id','=','admin_action_product_price.action_id')
                                ->where('admin_action_product_price.admin_id', $admin_id)
                                ->orderBy('admin_action_product_price.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product_price')
                            ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                            ->join('product','product.product_id','=','product_price.product_id')
                            ->join('action','action.action_id','=','admin_action_product_price.action_id')
                            ->where('admin_action_product_price.admin_id', $admin_id)
                            ->where('admin_action_product_price.action_id', $type_action)
                            ->orderBy('admin_action_product_price.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giá sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_product_price')
                                ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                                ->join('product','product.product_id','=','product_price.product_id')
                                ->join('action','action.action_id','=','admin_action_product_price.action_id')
                                ->where('admin_action_product_price.admin_id', $admin_id)
                                ->where('product_price.product_id', $product_id)
                                ->orderBy('admin_action_product_price.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giá sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product_price')
                            ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                            ->join('product','product.product_id','=','product_price.product_id')
                            ->join('action','action.action_id','=','admin_action_product_price.action_id')
                            ->where('admin_action_product_price.admin_id', $admin_id)
                            ->where('product_price.product_id', $product_id)
                            ->where('admin_action_product_price.action_id', $type_action)
                            ->orderBy('admin_action_product_price.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_price_product_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_product_price')
                                ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                                ->join('product','product.product_id','=','product_price.product_id')
                                ->join('action','action.action_id','=','admin_action_product_price.action_id')
                                ->where('admin_action_product_price.admin_id', $admin_id)
                                ->orderBy('admin_action_product_price.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product_price')
                            ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                            ->join('product','product.product_id','=','product_price.product_id')
                            ->join('action','action.action_id','=','admin_action_product_price.action_id')
                            ->where('admin_action_product_price.admin_id', $admin_id)
                            ->where('admin_action_product_price.action_id', $type_action)
                            ->orderBy('admin_action_product_price.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giá sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_product_price')
                                ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                                ->join('product','product.product_id','=','product_price.product_id')
                                ->join('action','action.action_id','=','admin_action_product_price.action_id')
                                ->where('admin_action_product_price.admin_id', $admin_id)
                                ->where('product_price.product_id', $product_id)
                                ->orderBy('admin_action_product_price.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giá sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_product_price')
                            ->join('product_price','product_price.price_id','=','admin_action_product_price.price_id')
                            ->join('product','product.product_id','=','product_price.product_id')
                            ->join('action','action.action_id','=','admin_action_product_price.action_id')
                            ->where('admin_action_product_price.admin_id', $admin_id)
                            ->where('product_price.product_id', $product_id)
                            ->where('admin_action_product_price.action_id', $type_action)
                            ->orderBy('admin_action_product_price.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_admin_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $admin_impact_id = $request->admin_id_single_date;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($admin_impact_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào nhân viên ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào nhân viên ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->where('admin_action_admin.action_id', $type_action)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_impact_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào nhân viên "'.$admin->admin_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->where('admin_action_admin.admin_impact_id', $admin_impact_id)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào nhân viên "'.$admin->admin_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_admin')
                            ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                            ->join('action','action.action_id','=','admin_action_admin.action_id')
                            ->where('admin_action_admin.admin_id', $admin_id)
                            ->where('admin_action_admin.action_id', $type_action)
                            ->where('admin_action_admin.admin_impact_id', $admin_impact_id)
                            ->orderBy('admin_action_admin.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_admin_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $admin_impact_id = $request->admin_id_many_date;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($admin_impact_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào nhân viên ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào nhân viên ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->where('admin_action_admin.action_id', $type_action)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_impact_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào nhân viên "'.$admin->admin_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_admin')
                                ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                                ->join('action','action.action_id','=','admin_action_admin.action_id')
                                ->where('admin_action_admin.admin_id', $admin_id)
                                ->where('admin_action_admin.admin_impact_id', $admin_impact_id)
                                ->orderBy('admin_action_admin.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào nhân viên "'.$admin->admin_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_admin')
                            ->join('admin','admin.admin_id','=','admin_action_admin.admin_impact_id')
                            ->join('action','action.action_id','=','admin_action_admin.action_id')
                            ->where('admin_action_admin.admin_id', $admin_id)
                            ->where('admin_action_admin.action_id', $type_action)
                            ->where('admin_action_admin.admin_impact_id', $admin_impact_id)
                            ->orderBy('admin_action_admin.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_product_image_side_profile_single_date(Request $request){
        $get_start_date = $request->start_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        if($product_id == 0){
            $title_trace = 'Truy vết dựa vào hình ảnh sản phẩm ngày '.
                        date('d/m/Y', strtotime($get_start_date));
            $all_admin_action = DB::table('admin_action_product_image')
                            ->join('product_image','product_image.image_id','=','admin_action_product_image.image_id')
                            ->join('product','product.product_id','=','product_image.product_id')
                            ->join('action','action.action_id','=','admin_action_product_image.action_id')
                            ->where('admin_action_product_image.admin_id', $admin_id)
                            ->orderBy('admin_action_product_image.action_time','asc')
                            ->get();
            foreach ($all_admin_action as $admin_action){
                $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                if($start_date == $time_action){
                    $admin_action->name_stuff = $admin_action->product_name;
                    $arrResult[] = $admin_action;
                }
            }
            $result_trace = $arrResult;
        }
        else{
            $product = Product::find($product_id);
            $title_trace = 'Truy vết dựa vào hình ảnh sản phẩm "'.$product->product_name.'" ngày '.
                        date('d/m/Y', strtotime($get_start_date));
            $all_admin_action = DB::table('admin_action_product_image')
                        ->join('product_image','product_image.image_id','=','admin_action_product_image.image_id')
                        ->join('product','product.product_id','=','product_image.product_id')
                        ->join('action','action.action_id','=','admin_action_product_image.action_id')
                        ->where('admin_action_product_image.admin_id', $admin_id)
                        ->where('product_image.product_id', $product_id)
                        ->orderBy('admin_action_product_image.action_time','asc')
                        ->get();
            foreach ($all_admin_action as $admin_action){
                $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                if($start_date == $time_action){
                    $admin_action->name_stuff = $admin_action->product_name;
                    $arrResult[] = $admin_action;
                }
            }
            $result_trace = $arrResult;
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_product_image_side_profile_many_date(Request $request){
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        if($product_id == 0){
            $title_trace = 'Truy vết dựa vào hình ảnh sản phẩm '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
            $all_admin_action = DB::table('admin_action_product_image')
                            ->join('product_image','product_image.image_id','=','admin_action_product_image.image_id')
                            ->join('product','product.product_id','=','product_image.product_id')
                            ->join('action','action.action_id','=','admin_action_product_image.action_id')
                            ->where('admin_action_product_image.admin_id', $admin_id)
                            ->orderBy('admin_action_product_image.action_time','asc')
                            ->get();
            foreach ($all_admin_action as $admin_action){
                $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                if($start_date <= $time_action && $time_action <= $end_date){
                    $admin_action->name_stuff = $admin_action->product_name;
                    $arrResult[] = $admin_action;
                }
            }
            $result_trace = $arrResult;
        }
        else{
            $product = Product::find($product_id);
            $title_trace = 'Truy vết dựa vào hình ảnh sản phẩm "'.$product->product_name.'" ngày '.
                        date('d/m/Y', strtotime($get_start_date)).'-'
                        .date('d/m/Y', strtotime($get_end_date));
            $all_admin_action = DB::table('admin_action_product_image')
                        ->join('product_image','product_image.image_id','=','admin_action_product_image.image_id')
                        ->join('product','product.product_id','=','product_image.product_id')
                        ->join('action','action.action_id','=','admin_action_product_image.action_id')
                        ->where('admin_action_product_image.admin_id', $admin_id)
                        ->where('product_image.product_id', $product_id)
                        ->orderBy('admin_action_product_image.action_time','asc')
                        ->get();
            foreach ($all_admin_action as $admin_action){
                $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                if($start_date <= $time_action && $time_action <= $end_date){
                    $admin_action->name_stuff = $admin_action->product_name;
                    $arrResult[] = $admin_action;
                }
            }
            $result_trace = $arrResult;
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_storage_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $storage_id = $request->storage_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;
            default:
                $name_action = '';
                break;
        }
        if($storage_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_storage')
                                ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                                ->join('action','action.action_id','=','admin_action_storage.action_id')
                                ->where('admin_action_storage.admin_id', $admin_id)
                                ->orderBy('admin_action_storage.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.action_id', $type_action)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $storage = Storage::find($storage_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$storage->storage_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.storage_id', $storage_id)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$storage->storage_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.action_id', $type_action)
                            ->where('admin_action_storage.storage_id', $storage_id)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_storage_side_profile_many_date(Request $request){
        $storage_id = $request->storage_id;
        $admin_id = $request->admin_id;
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;
            default:
                $name_action = '';
                break;
        }
        if($storage_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày'.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_storage')
                                ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                                ->join('action','action.action_id','=','admin_action_storage.action_id')
                                ->where('admin_action_storage.admin_id', $admin_id)
                                ->orderBy('admin_action_storage.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.action_id', $type_action)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $storage = Storage::find($storage_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$storage->storage_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.storage_id', $storage_id)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$storage->storage_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage')
                            ->join('storage','storage.storage_id','=','admin_action_storage.storage_id')
                            ->join('action','action.action_id','=','admin_action_storage.action_id')
                            ->where('admin_action_storage.admin_id', $admin_id)
                            ->where('admin_action_storage.action_id', $type_action)
                            ->where('admin_action_storage.storage_id', $storage_id)
                            ->orderBy('admin_action_storage.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->storage_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_storage_product_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;

            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_storage_product')
                                ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                                ->join('product','product.product_id','=','storage_product.product_id')
                                ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                                ->where('admin_action_storage_product.admin_id', $admin_id)
                                ->orderBy('admin_action_storage_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('admin_action_storage_product.action_id', $type_action)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('storage_product.product_id', $product_id)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                            $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('storage_product.product_id', $product_id)
                            ->where('admin_action_storage_product.action_id', $type_action)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_storage_product_side_profile_many_date(Request $request){
        $product_id = $request->product_id;
        $admin_id = $request->admin_id;
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm';
                break;
            case '2':
                $name_action = 'Sửa';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            case '4':
                $name_action = 'Khôi phục xóa';
                break;
            case '5':
                $name_action = 'Xóa vĩnh viễn';
                break;
            default:
                $name_action = '';
                break;
        }
        if($product_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_storage_product')
                                ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                                ->join('product','product.product_id','=','storage_product.product_id')
                                ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                                ->where('admin_action_storage_product.admin_id', $admin_id)
                                ->orderBy('admin_action_storage_product.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('admin_action_storage_product.action_id', $type_action)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $product = Product::find($product_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('storage_product.product_id', $product_id)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào kho sản phẩm "'.$product->product_name.'" ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                            $all_admin_action = DB::table('admin_action_storage_product')
                            ->join('storage_product','storage_product.storage_product_id','=','admin_action_storage_product.storage_product_id')
                            ->join('product','product.product_id','=','storage_product.product_id')
                            ->join('action','action.action_id','=','admin_action_storage_product.action_id')
                            ->where('admin_action_storage_product.admin_id', $admin_id)
                            ->where('storage_product.product_id', $product_id)
                            ->where('admin_action_storage_product.action_id', $type_action)
                            ->orderBy('admin_action_storage_product.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->product_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.admin.view_find_trace_side_profile', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_discount_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $admin_id = $request->admin_id;
        $discount_id = $request->discount_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm giảm giá';
                break;
            case '2':
                $name_action = 'Thiết lập lại giảm giá';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            default:
                $name_action = '';
                break;
        }
        if($admin_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_discount')
                                ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                                ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                                ->join('action','action.action_id','=','admin_action_discount.action_id')
                                ->where('admin_action_discount.discount_id', $discount_id)
                                ->orderBy('admin_action_discount.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.action_id', $type_action)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.admin_id', $admin_id)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.admin_id', $admin_id)
                            ->where('admin_action_discount.action_id', $type_action)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.discount.view_trace_side_discount', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_discount_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $admin_id = $request->admin_id;
        $discount_id = $request->discount_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm giảm giá';
                break;
            case '2':
                $name_action = 'Thiết lập lại giảm giá';
                break;
            case '3':
                $name_action = 'Xóa';
                break;
            default:
                $name_action = '';
                break;
        }
        if($admin_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_discount')
                                ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                                ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                                ->join('action','action.action_id','=','admin_action_discount.action_id')
                                ->where('admin_action_discount.discount_id', $discount_id)
                                ->orderBy('admin_action_discount.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.action_id', $type_action)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.admin_id', $admin_id)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào giảm giá sản phẩm do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_discount')
                            ->join('admin','admin.admin_id','=','admin_action_discount.admin_id')
                            ->join('discount','discount.discount_id','=','admin_action_discount.discount_id')
                            ->join('action','action.action_id','=','admin_action_discount.action_id')
                            ->where('admin_action_discount.admin_id', $admin_id)
                            ->where('admin_action_discount.action_id', $type_action)
                            ->where('admin_action_discount.discount_id', $discount_id)
                            ->orderBy('admin_action_discount.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.discount.view_trace_side_discount', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_voucher_side_profile_single_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $admin_id = $request->admin_id;
        $product_id = $request->product_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm voucher';
                break;
            case '2':
                $name_action = 'Thiết lập lại voucher';
                break;
            case '3':
                $name_action = 'Xóa voucher';
                break;
            default:
                $name_action = '';
                break;
        }
        if($admin_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào voucher ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_voucher')
                                ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                                ->join('product','product.product_id','=','voucher.product_id')
                                ->join('action','action.action_id','=','admin_action_voucher.action_id')
                                ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                                ->where('voucher.product_id',$product_id)
                                ->orderBy('admin_action_voucher.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('admin_action_voucher.action_id', $type_action)
                            ->where('voucher.product_id',$product_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào voucher do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date));
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('voucher.product_id',$product_id)
                            ->where('admin_action_voucher.admin_id',$admin_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào voucher do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('admin_action_voucher.action_id', $type_action)
                            ->where('voucher.product_id',$product_id)
                            ->where('admin_action_voucher.admin_id',$admin_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date == $time_action){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.voucher.view_trace_voucher', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
    public function trace_voucher_side_profile_many_date(Request $request){
        $type_action = $request->type_action;
        $get_start_date = $request->start_date;
        $get_end_date = $request->end_date;
        $admin_id = $request->admin_id;
        $product_id = $request->product_id;

        $start_date = date('Y-m-d', strtotime($get_start_date));
        $end_date = date('Y-m-d', strtotime($get_end_date));
        $arrResult = array();
        $title_trace = '';
        $name_action = '';
        switch ($type_action) {
            case '1':
                $name_action = 'Thêm voucher';
                break;
            case '2':
                $name_action = 'Thiết lập lại voucher';
                break;
            case '3':
                $name_action = 'Xóa voucher';
                break;
            default:
                $name_action = '';
                break;
        }
        if($admin_id == 0){
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào voucher ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_voucher')
                                ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                                ->join('product','product.product_id','=','voucher.product_id')
                                ->join('action','action.action_id','=','admin_action_voucher.action_id')
                                ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                                ->where('voucher.product_id',$product_id)
                                ->orderBy('admin_action_voucher.action_time','asc')
                                ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.
                            $name_action;
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('admin_action_voucher.action_id', $type_action)
                            ->where('voucher.product_id',$product_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        else{
            $admin = Admin::find($admin_id);
            if($type_action == '0'){
                $title_trace = 'Truy vết dựa vào voucher do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date));
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('voucher.product_id',$product_id)
                            ->where('admin_action_voucher.admin_id',$admin_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
            else{
                $title_trace = 'Truy vết dựa vào voucher do "'.$admin->admin_name.'" thực hiện ngày '.
                            date('d/m/Y', strtotime($get_start_date)).'-'
                            .date('d/m/Y', strtotime($get_end_date)).' với thao tác '.$name_action;
                $all_admin_action = DB::table('admin_action_voucher')
                            ->join('voucher','voucher.voucher_id','=','admin_action_voucher.voucher_id')
                            ->join('product','product.product_id','=','voucher.product_id')
                            ->join('action','action.action_id','=','admin_action_voucher.action_id')
                            ->join('admin','admin.admin_id','=','admin_action_voucher.admin_id')
                            ->where('admin_action_voucher.action_id', $type_action)
                            ->where('voucher.product_id',$product_id)
                            ->where('admin_action_voucher.admin_id',$admin_id)
                            ->orderBy('admin_action_voucher.action_time','asc')
                            ->get();
                foreach ($all_admin_action as $admin_action){
                    $time_action = date('Y-m-d', strtotime($admin_action->action_time));
                    if($start_date <= $time_action && $time_action <= $end_date){
                        $admin_action->name_stuff = $admin_action->admin_name;
                        $arrResult[] = $admin_action;
                    }
                }
                $result_trace = $arrResult;
            }
        }
        echo view('admin.voucher.view_trace_voucher', [
            'result_trace' => $result_trace,
            'title_trace' => $title_trace,
        ]);
    }
}
