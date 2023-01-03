<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImageProduct;
use App\Product;
use App\Admin_Action_Product_Image;
use Session;
use Carbon\Carbon;

class ImageProductController extends Controller
{
    public function all_gallery_product($prod_id){
        $all_product = Product::all();
        $all_image = ImageProduct::where('product_id',$prod_id)->get();
        return view('admin.image_product.all_gallery_product',
            ['prod_id'=>$prod_id,'all_image'=>$all_image,'all_product'=>$all_product]);
    }
    public function process_add_image_product($prod_id, Request $request){
        $request -> validate(
            [
                'image' => 'required'
            ],[
                'image.required' => 'Bạn chưa chọn hình ảnh để thêm'
            ]
            );
        $get_image = $request->file('image');
        $image_product = new ImageProduct();
        if(isset($get_image)){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload',$new_image);
            $image_product->image = $new_image;
        }
        $image_product->product_id = $prod_id;
        $result_add_image_product = $image_product->save();
        if($result_add_image_product){
            $admin_action_product_image = new Admin_Action_Product_Image();
            $admin_action_product_image->admin_id = Session::get('admin_id');
            $admin_action_product_image->image_id = $image_product->image_id;
            $admin_action_product_image->action_id = 1;
            $admin_action_product_image->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product_image->action_message = 'Thêm hình ảnh sản phẩm';
            $admin_action_product_image->save();
        }
        $request->session()->flash('add_product_image_success', 'Thêm thành công hình ảnh của sản phẩm');
        return redirect()->back();
    }

    public function delete_soft_image_product(Request $request){
        $image_id = $request->image_id;
        $soft_delete = ImageProduct::where('image_id', $image_id)->delete();
        if($soft_delete){
            $admin_action_product_image = new Admin_Action_Product_Image();
            $admin_action_product_image->admin_id = Session::get('admin_id');
            $admin_action_product_image->image_id = $image_id;
            $admin_action_product_image->action_id = 3;
            $admin_action_product_image->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product_image->action_message = 'Xóa hình ảnh thành công';
            $admin_action_product_image->save();
        }
        $request->session()->flash('delete_product_image_success', 'Xóa thành công hình ảnh của sản phẩm');
        return redirect()->back();
    }
    public function view_recycle_image_product($prod_id){
        $recycle_image = ImageProduct::onlyTrashed()->where('product_id',$prod_id)->get();
        return view('admin.image_product.view_recycle_image',['recycle_image'=>$recycle_image,'prod_id'=>$prod_id]);
    }
    public function restore_image_product($image_id, Request $request){
        $restore = ImageProduct::withTrashed()->where('image_id', $image_id)->restore();
        if($restore){
            $admin_action_product_image = new Admin_Action_Product_Image();
            $admin_action_product_image->admin_id = Session::get('admin_id');
            $admin_action_product_image->image_id = $image_id;
            $admin_action_product_image->action_id = 4;
            $admin_action_product_image->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product_image->action_message = 'Khôi phục hình ảnh từ thùng rác';
            $admin_action_product_image->save();
            $request->session()->flash('restore_image_success', 'Khôi phục hình ảnh thành công');
        }
        return redirect()->back();
    }
    public function delete_forever_image_product(Request $request){
        $image_id = $request->image_id;
        $delete_forever = ImageProduct::withTrashed()->where('image_id', $image_id)->forceDelete();
        if($delete_forever){
            $admin_action_product_image = new Admin_Action_Product_Image();
            $admin_action_product_image->admin_id = Session::get('admin_id');
            $admin_action_product_image->image_id = $image_id;
            $admin_action_product_image->action_id = 5;
            $admin_action_product_image->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product_image->action_message = 'Xóa vĩnh viễn sản phẩm';
            $admin_action_product_image->save();
            $request->session()->flash('delete_image_forever', 'Xóa vĩnh viễn hình ảnh sản phẩm thành công');
        }
        return redirect()->back();
    }
}
