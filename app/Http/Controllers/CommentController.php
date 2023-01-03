<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Customer_Info;
use App\Rating;
use App\Comment;
use App\Product;
use DB;
use Session;
use PDF;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public static function count_product_in_comment($product_id){
        $Ob_count_product = (object)[];
        $comment = DB::table('customer')
            ->join('comment', 'comment.customer_id', '=', 'customer.customer_id')
            ->join('rating', 'rating.customer_id', '=', 'customer.customer_id')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->where('comment.status', 0)
            ->where('comment.product_id', $product_id)
            ->get();
        if(count($comment) > 0){
            $Ob_count_product = $comment;
        }
        return $Ob_count_product;
    }
    public function view_comment_to_process(){
        $all_product = Product::all();
        $all_customer = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();
        $all_comment = Comment::where('status', 0)->get();
        $all_rating = Rating::all();
        return view('admin.comment.view_list_comment',[
            'all_product' => $all_product,
            'all_customer' => $all_customer,
            'all_comment' => $all_comment,
            'all_rating' => $all_rating,
        ]);
    }
    public function process_accep_comment(Request $request){
        $comment_id = $request->comment_id;
        if($comment_id != ''){
            $accept_comment = Comment::find($comment_id);
            $accept_comment->status = 1;
            $result = $accept_comment->save();
            if($result){
                $request->session()->flash('accept_comment_success', 'Duyệt bình luận thành công');
            }
            else{
                $request->session()->flash('accept_comment_error', 'Duyệt bình luận thất bại');
            }
        }
        else{
            $request->session()->flash('accept_comment_error', 'Duyệt bình luận thất bại');
        }
        return redirect()->back();
    }
    public function process_accep_comment_when_filter(Request $request, $comment_id){
        $accept_comment = Comment::find($comment_id);
        $accept_comment->status = 1;
        $result = $accept_comment->save();
        if($result){
            $request->session()->flash('accept_comment_success', 'Duyệt bình luận thành công');
        }
        else{
            $request->session()->flash('accept_comment_error', 'Duyệt bình luận thất bại');
        }
        return redirect()->back();
    }
    public function process_unaccep_comment(Request $request){
        $comment_id = $request->comment_id;
        if($comment_id != ''){
            $unaccept_comment = Comment::find($comment_id);
            $result = $unaccept_comment->delete();
            if($result){
                $request->session()->flash('unaccept_comment_success', 'Xóa bình luận thành công');
            }
            else{
                $request->session()->flash('unaccept_comment_error', 'Xóa bình luận thất bại');
            }
        }
        else{
            $request->session()->flash('unaccept_comment_error', 'Xóa bình luận thất bại');
        }
        return redirect()->back();
    }
    public function process_unaccep_comment_when_filter(Request $request, $comment_id){
        $unaccept_comment = Comment::find($comment_id);
        $result = $unaccept_comment->delete();
        if($result){
            $request->session()->flash('unaccept_comment_success', 'Xóa bình luận thành công');
        }
        else{
            $request->session()->flash('unaccept_comment_error', 'Xóa bình luận thất bại');
        }
        return redirect()->back();
    }
    public function filter_comment_fol_product(Request $request){
        $product_id = $request->product_id;

        $type_filter = 'product';
        $level_filter = $product_id;

        $product = Product::find($product_id);
        $string_title = 'Danh Sách Bình Luận Theo Sản Phẩm - "'.$product->product_name.'"';

        $all_customer = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();
        $all_rating = Rating::all();

        $all_comment = DB::table('comment')
            ->join('product', 'product.product_id', '=', 'comment.product_id')
            ->where('comment.product_id', $product_id)
            ->where('comment.status', 0)
            ->get();

        echo view('admin.comment.view_filter_comment',[
            'all_comment' => $all_comment,

            'all_rating' => $all_rating,
            'all_customer' => $all_customer,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_comment_fol_rating(Request $request){
        $rating = $request->rating;
        $string_title = 'Danh Sách Bình Luận Theo Đánh Giá '.$rating.' Sao Trở Lên';

        $type_filter = 'rating';
        $level_filter = $rating;

        $all_rating = Rating::all();
        $products = Product::all();
        $all_customer = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();

        $all_comment_get = DB::table('comment')
            ->join('product', 'product.product_id', '=', 'comment.product_id')
            ->where('comment.status', 0)
            ->get();

        $arrComment = array();
        foreach($all_rating as $rate){
            foreach ($all_comment_get as $comment){
                if($rate->customer_id == $comment->customer_id
                    && $rate->product_id == $comment->product_id
                    && $rate->rating_level >= $rating){
                        $arrComment[] = $comment;
                }
            }
        }
        $all_comment = $arrComment;

        echo view('admin.comment.view_filter_comment',[
            'all_comment' => $all_comment,

            'all_rating' => $all_rating,
            'all_customer' => $all_customer,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function print_pdf_comment(Request $request){
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;

        $all_customer = DB::table('customer')
                        ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                        ->get();
        $all_rating = Rating::all();

        switch ($type_filter) {
            
            case "product":

                    $product = Product::find($level_filter);
                    $string_title = 'Danh Sách Bình Luận Theo Sản Phẩm - "'.$product->product_name.'"';

                    $all_comment = DB::table('comment')
                        ->join('product', 'product.product_id', '=', 'comment.product_id')
                        ->where('comment.product_id', $level_filter)
                        ->where('comment.status', 0)
                        ->get();

                    $pdf = PDF::loadView('admin.comment.view_print_pdf_comment', [
                        'all_comment'=>$all_comment,
                        'string_title'=>$string_title,
                        'all_rating' => $all_rating,
                        'all_customer' => $all_customer,
                        'string_title' => $string_title,
                    ]);
                    return $pdf->download('list_comment_fol_product.pdf');
                break;
            case "rating":
                    $string_title = 'Danh Sách Bình Luận Theo Đánh Giá '.$level_filter.' Sao Trở Lên';

                    $all_comment_get = DB::table('comment')
                        ->join('product', 'product.product_id', '=', 'comment.product_id')
                        ->where('comment.status', 0)
                        ->get();

                    $arrComment = array();
                    foreach($all_rating as $rate){
                        foreach ($all_comment_get as $comment){
                            if($rate->customer_id == $comment->customer_id
                                && $rate->product_id == $comment->product_id
                                && $rate->rating_level >= $level_filter){
                                    $arrComment[] = $comment;
                            }
                        }
                    }
                    $all_comment = $arrComment;
                    $pdf = PDF::loadView('admin.comment.view_print_pdf_comment', [
                        'all_comment'=>$all_comment,
                        'string_title'=>$string_title,
                        'all_rating' => $all_rating,
                        'all_customer' => $all_customer,
                        'string_title' => $string_title,
                    ]);
                    return $pdf->download('list_comment_fol_rating.pdf');
                break;
            default :
                $string_title = 'Danh Sách Bình Luận';
                $all_comment = DB::table('comment')
                            ->join('product', 'product.product_id', '=', 'comment.product_id')
                            ->where('comment.status', 0)
                            ->get();
                $pdf = PDF::loadView('admin.comment.view_print_pdf_comment', [
                    'all_comment'=>$all_comment,
                    'string_title'=>$string_title,
                    'all_rating' => $all_rating,
                    'all_customer' => $all_customer,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('list_comment.pdf');

        }
    }
}
