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
use App\Admin_Action_Storage_Product;
use App\Admin_Action_Product;
use App\Admin_Action_Product_Price;
use App\Comment;
use Session;
use DB;
use Carbon\Carbon;
use PDF;
use Str;

class ProductController extends Controller
{
    public function add_product()
    {
        $category = Category::all();
        $unit_product = Unit::all();
        $storage = Storage::all();
        return view(
            'admin.product.add_product',
            ['category' => $category, 'unit_product' => $unit_product, 'storage' => $storage]
        );
    }
    public function process_add_product(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->Validate_Product($request);

        $name_product = $request->product_name;
        $check_name = Product::where('product_name', $name_product)->first();
        if ($check_name) {
            $request->session()->flash('add_product_error_name', 'Thêm sản phẩm thất bại, sản phẩm đã tồn tại');
            return redirect()->back();
        }
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->slug = Str::slug($request->product_name);
        $product->category_id = $request->cate_id;
        $product->unit_id = $request->unit_id;
        $product->product_sort_desc = $request->product_sort_desc;
        $product->product_desc = $request->product_desc;
        $get_image = $request->file('product_image');
        if (isset($get_image)) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload', $new_image);
            $product->product_image = $new_image;
        } else {
            $product->product_image = ('no_image.png');
        }
        $result_add_product = $product->save();
        if (!$result_add_product) {
            $request->session()->flash('add_product_error', 'Thêm sản phẩm thất bại');
            return redirect()->back();
        }

        $admin_action_product = new Admin_Action_Product();
        $admin_action_product->admin_id = Session::get('admin_id');
        $admin_action_product->product_id = $product->product_id;
        $admin_action_product->action_id = 1;
        $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
        $admin_action_product->action_message = 'Thêm sản phẩm';
        $result_add_admin_action_product = $admin_action_product->save();
        if (!$result_add_admin_action_product) {
            $request->session()->flash('admin_action_product_error', 'admin action product fail');
            return redirect()->back();
        }

        $product_price = new ProductPrice();
        $product_price->product_id = $product->product_id;
        $product_price->price = $request->product_price;
        $product_price->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $result_add_product_price = $product_price->save();
        if (!$result_add_product_price) {
            $request->session()->flash('add_product_price_error', 'Thêm giá sản phẩm thất bại');
            return redirect()->back();
        }

        $admin_action_product_price = new Admin_Action_Product_Price();
        $admin_action_product_price->admin_id = Session::get('admin_id');
        $admin_action_product_price->price_id = $product_price->price_id;
        $admin_action_product_price->action_id = 1;
        $admin_action_product_price->action_time = Carbon::now('Asia/Ho_Chi_Minh');
        $admin_action_product_price->action_message = 'Thêm giá sản phẩm';
        $result_add_admin_action_product_price = $admin_action_product_price->save();
        if (!$result_add_admin_action_product_price) {
            $request->session()->flash('admin_action_product_price_error', 'admin action product price fail');
            return redirect()->back();
        }

        $storage_product = new Storage_Product();
        $storage_product->storage_id = $request->storage_id;
        $storage_product->product_id = $product->product_id;
        $total_quantity_product = $request->product_quantity;
        if ($total_quantity_product) {
            $storage_product->total_quantity_product = $request->product_quantity;
        } else {
            $storage_product->total_quantity_product = 0;
        }
        $result_add_storage_product = $storage_product->save();
        if (!$result_add_storage_product) {
            $request->session()->flash('add_storage_product_error', 'Thêm số lượng vào kho sản phẩm thất bại');
            return redirect()->back();
        }

        $admin_action_storage_product = new Admin_Action_Storage_Product();
        $admin_action_storage_product->admin_id = Session::get('admin_id');
        $admin_action_storage_product->storage_product_id = $storage_product->storage_product_id;
        $admin_action_storage_product->action_id = 1;
        $admin_action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
        $admin_action_storage_product->action_message = 'Thêm số lượng sản phẩm';
        $result_admin_action_storage_product = $admin_action_storage_product->save();
        if (!$result_admin_action_storage_product) {
            $request->session()->flash('admin_action_add_storage_product_error', 'Admin action storage product fail');
            return redirect()->back();
        }

        $request->session()->flash('add_product_success', 'Thêm sản phẩm mới thành công');
        return redirect('admin/all_product');
    }
    public function all_product()
    {
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->paginate(10);
        $all_cate = Category::all();
        $all_storage = Storage::all();
        //
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($all_product as $prod) {
            $prod_id = $prod->product_id;
            $date_now = strtotime($now);
            $time_cre = strtotime($prod->create_at);
            $minus_date = abs($date_now - $time_cre);
            $check_date = floor($minus_date / (60 * 60 * 24));

            if ($check_date <= 3) {
                DB::table('product')->where('product_id', $prod->product_id)->update(['is_new' => 1]);
            } else {
                DB::table('product')->where('product_id', $prod->product_id)->update(['is_new' => 0]);
            }
        }
        $all_product_new = Product::where('is_new', 1)->get();
        $all_product_featured = Product::where('is_featured', 1)->get();
        $all_product_discount = Product::where('discount_id', '!=', null)->get();
        return view(
            'admin.product.all_product',
            [
                'all_product' => $all_product,
                'all_product_new' => $all_product_new,
                'all_product_featured' => $all_product_featured,
                'all_product_discount' => $all_product_discount,
                'all_cate' => $all_cate,
                'all_storage' => $all_storage,
            ]
        );
    }
    public function is_featured(Request $request, $prod_id)
    {
        $is_featured = DB::table('product')->where('product_id', $prod_id)->update(['is_featured' => 1]);
        $request->session()->flash('change_status', 'Thay đổi trạng thái thành công');
        return redirect()->back();
    }
    public function is_not_featured(Request $request, $prod_id)
    {
        $is_not_featured = DB::table('product')->where('product_id', $prod_id)->update(['is_featured' => 0]);
        $request->session()->flash('change_status', 'Thay đổi trạng thái thành công');
        return redirect()->back();
    }
    public function update_product($prod_id)
    {
        $update_product = Product::find($prod_id);
        $category = Category::all();
        $unit_product = Unit::all();
        $storage = Storage::all();
        $storage_product = Storage_Product::where('product_id', $prod_id)->first();
        return view(
            'admin.product.update_product',
            [
                'update_product' => $update_product,
                'category' => $category,
                'unit_product' => $unit_product,
                'storage' => $storage,
                'storage_product' => $storage_product,
            ]
        );
    }
    public function process_update_product(Request $request, $prod_id)
    {
        $this->Validate_Product_Update($request);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $name_product = $request->product_name;
        $check_name = Product::where('product_name', $name_product)
            ->where('product_id', '!=', $prod_id)->first();
        if ($check_name) {
            $request->session()->flash('update_product_error_name', 'Cập nhật sản phẩm thất bại, tên sản phẩm đã tồn tại');
            return redirect()->back();
        }

        $update_product = Product::find($prod_id);
        $update_product->product_name = $request->product_name;
        $update_product->slug = Str::slug($request->product_name);
        $update_product->category_id = $request->cate_id;
        $update_product->unit_id = $request->unit_id;
        $update_product->product_sort_desc = $request->product_sort_desc;
        $update_product->product_desc = $request->product_desc;
        $get_image = $request->file('product_image');
        if (isset($get_image)) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload', $new_image);
            $update_product->product_image = $new_image;
            $result_update_product = $update_product->save();
            if ($result_update_product) {
                $admin_action_product = new Admin_Action_Product();
                $admin_action_product->admin_id = Session::get('admin_id');
                $admin_action_product->product_id = $prod_id;
                $admin_action_product->action_id = 2;
                $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $admin_action_product->action_message = 'Sửa thông tin sản phẩm';
                $admin_action_product->save();
                $request->session()->flash('update_product_success', 'Chỉnh sửa sản phẩm thành công');
            }
        } else {
            $result_update_product = $update_product->save();
            if ($result_update_product) {
                $admin_action_product = new Admin_Action_Product();
                $admin_action_product->admin_id = Session::get('admin_id');
                $admin_action_product->product_id = $prod_id;
                $admin_action_product->action_id = 2;
                $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $admin_action_product->action_message = 'Sửa thông tin sản phẩm';
                $admin_action_product->save();
                $request->session()->flash('update_product_success', 'Chỉnh sửa sản phẩm thành công');
            }
        }
        $storage_product = Storage_Product::where('product_id', $prod_id)->first();
        $storage_product->storage_id = $request->storage_id;
        $result_update_storage_product = $storage_product->save();
        if ($result_update_storage_product) {
            $admin_action_storage_product = new Admin_Action_Storage_Product();
            $admin_action_storage_product->admin_id = Session::get('admin_id');
            $admin_action_storage_product->storage_product_id = $storage_product->storage_product_id;
            $admin_action_storage_product->action_id = 2;
            $admin_action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_storage_product->action_message = 'Sửa thông tin kho của kho sản phẩm';
            $admin_action_storage_product->save();
        }

        return redirect('admin/all_product');
    }
    public function soft_delete_product(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $product_id = $request->product_id;
        $quantity_product = Storage_Product::where('product_id', $product_id)->first();
        if ($quantity_product->total_quantity_product != 0) {
            $request->session()->flash('delete_error', 'Sản phẩm chưa hết hàng, không thể xóa');
            return redirect()->back();
        } else {
            $soft_delete_storage_product = Storage_Product::where('product_id', $product_id)->delete();
            $soft_delete_product = Product::where('product_id', $product_id)->delete();
            if ($soft_delete_product) {
                $admin_action_product = new Admin_Action_Product();
                $admin_action_product->admin_id = Session::get('admin_id');
                $admin_action_product->product_id = $product_id;
                $admin_action_product->action_id = 3;
                $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $admin_action_product->action_message = 'Xóa product';
                $admin_action_product->save();
                $request->session()->flash('delete_success', 'Xóa thành công');
                return redirect()->back();
            }
        }
    }
    public function delete_when_find_product(Request $request, $product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $quantity_product = Storage_Product::where('product_id', $product_id)->first();
        if ($quantity_product->total_quantity_product != 0) {
            $request->session()->flash('delete_error', 'Sản phẩm chưa hết hàng, không thể xóa');
            return redirect()->back();
        } else {
            $soft_delete_storage_product = Storage_Product::where('product_id', $product_id)->delete();
            $soft_delete_product = Product::where('product_id', $product_id)->delete();
            if ($soft_delete_product) {
                $admin_action_product = new Admin_Action_Product();
                $admin_action_product->admin_id = Session::get('admin_id');
                $admin_action_product->product_id = $product_id;
                $admin_action_product->action_id = 3;
                $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $admin_action_product->action_message = 'Xóa product';
                $admin_action_product->save();
                $request->session()->flash('delete_success', 'Xóa thành công');
                return redirect()->back();
            }
        }
    }
    public function view_recycle_product()
    {
        $recycle_item = Product::onlyTrashed()->get();
        return view('admin.product.all_recycle_product', ['recycle_item' => $recycle_item]);
    }
    public function re_delete_product($prod_id, Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $restore_product = Product::withTrashed()->where('product_id', $prod_id)->restore();
        $restore_storage_product = Storage_Product::withTrashed()->where('product_id', $prod_id)->restore();
        if ($restore_product && $restore_storage_product) {
            $admin_action_product = new Admin_Action_Product();
            $admin_action_product->admin_id = Session::get('admin_id');
            $admin_action_product->product_id = $prod_id;
            $admin_action_product->action_id = 4;
            $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product->action_message = 'Khôi phục sản phẩm từ thùng rác';
            $admin_action_product->save();
        }
        $request->session()->flash('restore_success', 'Khôi phục thành công');
        return redirect()->back();
    }
    public function delete_forever_product(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $product_id = $request->product_id_delete_forever;
        $delete_forever_product = Product::withTrashed()->where('product_id', $product_id)->forceDelete();
        $delete_forever_storage_product = Storage_Product::withTrashed()->where('product_id', $product_id)->forceDelete();
        $delete_forever_image_product = ImageProduct::withTrashed()->where('product_id', $product_id)->forceDelete();
        $delete_forever_product_price = ProductPrice::withTrashed()->where('product_id', $product_id)->forceDelete();
        if ($delete_forever_product) {
            $admin_action_product = new Admin_Action_Product();
            $admin_action_product->admin_id = Session::get('admin_id');
            $admin_action_product->product_id = $product_id;
            $admin_action_product->action_id = 5;
            $admin_action_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_product->action_message = 'Xóa vĩnh viễn sản phẩm';
            $admin_action_product->save();
        }
        $request->session()->flash('delete_product_forever_success', 'Xóa thành công sản phẩm');
        return redirect()->back();
    }
    public function find_product(Request $request)
    {
        $val_find = $request->val_find;
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product_name', 'LIKE', '%' . $val_find . '%')
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        echo view('admin.product.view_find_product', [
            'all_product' => $all_product,
        ]);
    }
    public function view_detail_product($prod_id)
    {

        $product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.product_id', $prod_id)
            ->first();
        $all_cate = Category::all();
        $all_unit = Unit::all();
        $all_storage = Storage::all();
        $comment = Comment::where('product_id', $prod_id)->get();
        return view(
            'admin.product.view_detail_product',
            [
                'product' => $product,
                'all_unit' => $all_unit,
                'all_storage' => $all_storage,
                'all_cate' => $all_cate,
                'comment' => $comment,
            ]
        );
    }
    //Validate
    public function Validate_Product(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'cate_id' => 'required',
            'product_price' => 'required|numeric|min:1000|max:10000000',
            'unit_id' => 'required',
            'storage_id' => 'required',
            'product_quantity' => 'nullable|alpha_num|min:0|max:10000',
            'product_sort_desc' => 'required|max:500',
            'product_desc' => 'required',
        ], [
            'product_name.required' => 'Tên sản phẩm không được để trống',
            'cate_id.required' => 'Bạn chưa chọn loại sản phẩm',
            'product_price.required' =>  'Bạn chưa nhập giá sản phẩm',
            'product_price.numeric' =>  'Giá của sản phẩm phải là số',
            'product_price.min' =>  'Giá của sản phẩm không thể nhỏ hơn 1000 vnđ',
            'product_price.max' =>  'Giá của sản phẩm tối đa là 10000000 vnđ',

            'unit_id.required' => 'Ban chưa chọn đơn vị tính',
            'storage_id.required' => 'Bạn chưa chọn kho hàng',
            'product_quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'product_quantity.max' => 'Số lượng không thể quá lớn',
            'product_quantity.alpha_num' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'product_sort_desc.max' => 'Không vượt quá 255 ký tự',
            'product_sort_desc.required' => 'Bạn không được để trống',
            'product_desc.required' => 'Mô tả sản phẩm không được để trống',
        ]);
    }
    public function Validate_Product_Update(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'cate_id' => 'required',
            'unit_id' => 'required',
            'storage_id' => 'required',
            'product_sort_desc' => 'required|max:500',
            'product_desc' => 'required',
        ], [
            'product_name.required' => 'Tên sản phẩm không được để trống',
            'cate_id.required' => 'Bạn chưa chọn loại sản phẩm',
            'product_price.required' =>  'Bạn chưa nhập giá sản phẩm',

            'unit_id.required' => 'Ban chưa chọn đơn vị tính',
            'storage_id.required' => 'Bạn chưa chọn kho hàng',
            'product_sort_desc.max' => 'Không vượt quá 255 ký tự',
            'product_sort_desc.required' => 'Bạn không được để trống',
            'product_desc.required' => 'Mô tả sản phẩm không được để trống',
        ]);
    }
    public function filter_new_product(Request $request)
    {
        $string_title = $request->string_new_product;

        $type_filter = 'new_product';
        $level_filter = '';

        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.is_new', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        echo view('admin.product.view_filter_product', [
            'all_product' => $all_product,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_feature(Request $request)
    {
        $string_title = $request->string_feature_product;

        $type_filter = 'feature_product';
        $level_filter = '';

        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.is_featured', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        echo view('admin.product.view_filter_product', [
            'all_product' => $all_product,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_cate(Request $request)
    {
        $cate_id = $request->cate_id;

        $type_filter = 'cate';
        $level_filter = $cate_id;

        $cate = Category::find($cate_id);
        $string_title = 'Sản Phẩm Theo Danh Mục "' . $cate->cate_name . '"';
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.category_id', $cate_id)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        echo view('admin.product.view_filter_product', [
            'all_product' => $all_product,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_cate_many(Request $request)
    {
        $arrCate = $request->arrCate;

        $type_filter = 'cate_many';
        $level_filter = '';
        $level_array = $arrCate;

        $string_title = 'Sản Phẩm Theo Danh Mục';
        $arrayProduct = array();
        foreach ($arrCate as $cate_id) {
            $all_product = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                ->where('product_price.status', 1)
                ->where('product.category_id', $cate_id)
                ->where('product.deleted_at', null)
                ->get();
            foreach ($all_product as $product) {
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortBy('product_id')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
            'level_array' => $level_array,
        ]);
    }
    public function filter_product_follow_storage(Request $request)
    {
        $storage_id = $request->storage_id;

        $type_filter = 'storage';
        $level_filter = $storage_id;

        $storage = Storage::find($storage_id);
        $string_title = 'Sản Phẩm Theo Kho "' . $storage->storage_name . '"';
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('storage_product.storage_id', $storage_id)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        echo view('admin.product.view_filter_product', [
            'all_product' => $all_product,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_storage_many(Request $request)
    {
        $arrStorage = $request->arrStorage;

        $type_filter = 'storage_many';
        $level_filter = '';
        $level_array = $arrStorage;

        $string_title = 'Sản Phẩm Theo Kho';
        $arrayProduct = array();
        foreach ($arrStorage as $storage_id) {
            $all_product = DB::table('product')
                ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                ->where('product_price.status', 1)
                ->where('storage_product.storage_id', $storage_id)
                ->where('product.deleted_at', null)
                ->get();
            foreach ($all_product as $product) {
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortBy('product_id')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
            'level_array' => $level_array,
        ]);
        //dd($arrayProduct);
    }
    public function filter_product_follow_price_choose(Request $request)
    {
        $level_filter_price = $request->radioChoosePrice;

        $type_filter = 'price';
        $level_filter = $level_filter_price;

        $price_start = 0;
        $price_end = 0;
        if ($level_filter_price == 1) {
            $price_start = 1000;
            $price_end = 100000;
        } else if ($level_filter_price == 2) {
            $price_start = 100000;
            $price_end = 500000;
        } else if ($level_filter_price == 3) {
            $price_start = 500000;
            $price_end = 1000000;
        } else if ($level_filter_price == 4) {
            $price_start = 1000000;
            $price_end = 2000000;
        }
        $string_title = 'Sản Phẩm Theo Giá " Từ ' . number_format($price_start, 0, ',', '.')
            . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        $arrayProduct = array();
        $callFunction = new HomeClientController;
        foreach ($all_product as $product) {
            $check_price = $callFunction->check_price_discount($product->product_id);
            $price_now = number_format($check_price->price_now, 0, ',', '');
            if ($price_start <= $price_now && $price_now <= $price_end) {
                $product->price_now =  $price_now;
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_price_cus_option(Request $request)
    {
        $price_start = $request->price_start;
        $price_end = $request->price_end;

        $type_filter = 'price_many';
        $level_filter = '';
        $price_filter_start = $price_start;
        $price_filter_end = $price_end;

        $string_title = 'Sản Phẩm Theo Giá " Từ ' . number_format($price_start, 0, ',', '.')
            . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        $arrayProduct = array();
        $callFunction = new HomeClientController;
        foreach ($all_product as $product) {
            $check_price = $callFunction->check_price_discount($product->product_id);
            $price_now = number_format($check_price->price_now, 0, ',', '');
            if ($price_start <= $price_now && $price_now <= $price_end) {
                $product->price_now =  $price_now;
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
            'price_filter_start' => $price_filter_start,
            'price_filter_end' => $price_filter_end,
        ]);
    }
    public function filter_product_follow_rating_choose(Request $request)
    {
        $rating_level = $request->radioChooseRating;

        $type_filter = 'rating';
        $level_filter = $rating_level;

        $string_title = 'Sản Phẩm Đánh Giá Từ ' . $rating_level . ' Sao';
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->orderBy('product.product_id', 'desc')
            ->get();
        $arrayProduct = array();
        $callFunction = new HomeClientController;
        foreach ($all_product as $product) {
            $check_rating = $callFunction->info_rating_saled($product->product_id);
            if ($check_rating->avg_rating >= $rating_level) {
                $product->avg_rating =  $check_rating->avg_rating;
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortBy('avg_rating')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_date_create_single(Request $request)
    {
        $date = $request->date;
        $date_filter = date('Y-m-d', strtotime($date));

        $type_filter = 'date';
        $level_filter = $date_filter;

        $string_title = 'Sản Phẩm Theo Ngày "' . date('d/m/Y', strtotime($date)) . '"';
        $arrayProduct = array();
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->get();
        foreach ($all_product as $product) {
            $date_create = date('Y-m-d', strtotime($product->create_at));
            if ($date_filter == $date_create) {
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortByDesc('create_at')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
        ]);
    }
    public function filter_product_follow_date_create_many(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $date_filter_start = date('Y-m-d', strtotime($date_start));
        $date_filter_end = date('Y-m-d', strtotime($date_end));

        $type_filter = 'date_many';
        $level_filter = '';
        $start_date = $date_filter_start;
        $end_date = $date_filter_end;

        $string_title = 'Sản Phẩm " Từ Ngày ' . date('d/m/Y', strtotime($date_start)) . '
                        Đến Ngày ' . date('d/m/Y', strtotime($date_filter_end)) . ' "';
        $arrayProduct = array();
        $all_product = DB::table('product')
            ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
            ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
            ->where('product_price.status', 1)
            ->where('product.deleted_at', null)
            ->get();
        foreach ($all_product as $product) {
            $date_create = date('Y-m-d', strtotime($product->create_at));
            if ($start_date <= $date_create && $date_create <= $end_date) {
                $arrayProduct[] = $product;
            }
        }
        $orderByArrayProduct = collect($arrayProduct)->sortByDesc('create_at')->reverse()->toArray();
        echo view('admin.product.view_filter_product', [
            'all_product' => $orderByArrayProduct,
            'string_title' => $string_title,
            'type_filter' => $type_filter,
            'level_filter' => $level_filter,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
    public function print_pdf_product(Request $request)
    {
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;

        switch ($type_filter) {
            case "cate":
                $cate = Category::find($level_filter);
                $string_title = 'Danh Sách Sản Phẩm Theo Danh Mục "' . $cate->cate_name . '"';
                $data = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.category_id', $level_filter)
                    ->where('product.deleted_at', null)
                    ->orderBy('product.create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheodanhmuc.pdf');
                break;
            case "new_product":
                $string_title = 'Danh Sách Sản Phẩm Mới';
                $data = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->where('product.is_new', 1)
                    ->orderBy('product.create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphammoi.pdf');
                break;
            case "feature_product":
                $string_title = 'Danh Sách Sản Phẩm Đặc Trưng';
                $data = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->where('product.is_featured', 1)
                    ->orderBy('product.create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamdactrung.pdf');
                break;
            case "cate_many":
                $level_array = $request->level_array;
                $string_title = 'Danh Sách Sản Phẩm Theo Danh Mục';

                $arrayProduct = array();
                foreach ($level_array as $cate_id) {
                    $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                        ->where('product_price.status', 1)
                        ->where('product.category_id', $cate_id)
                        ->where('product.deleted_at', null)
                        ->get();
                    foreach ($all_product as $product) {
                        $arrayProduct[] = $product;
                    }
                }
                $data = (object)$arrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheonhieudanhmuc.pdf');
                break;
            case "storage":
                $storage = Storage::find($level_filter);
                $string_title = 'Danh Sách Sản Phẩm Thuộc Kho "' . $storage->storage_name . '"';
                $data = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->where('storage_product.storage_id', $level_filter)
                    ->orderBy('product.create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheokho.pdf');
                break;
            case "storage_many":
                $level_array = $request->level_array;
                $string_title = 'Danh Sách Sản Phẩm Theo Kho';

                $arrayProduct = array();
                foreach ($level_array as $storage_id) {
                    $all_product = DB::table('product')
                        ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                        ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                        ->where('product_price.status', 1)
                        ->where('storage_product.storage_id', $storage_id)
                        ->where('product.deleted_at', null)
                        ->get();
                    foreach ($all_product as $product) {
                        $arrayProduct[] = $product;
                    }
                }
                $data = (object)$arrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheonhieukho.pdf');
                break;
            case "price":
                if ($level_filter == 1) {
                    $price_start = 1000;
                    $price_end = 100000;
                } else if ($level_filter == 2) {
                    $price_start = 100000;
                    $price_end = 500000;
                } else if ($level_filter == 3) {
                    $price_start = 500000;
                    $price_end = 1000000;
                } else if ($level_filter == 4) {
                    $price_start = 1000000;
                    $price_end = 2000000;
                }
                $string_title = 'Danh Sách Đơn Hàng Theo Giá " Từ ' . number_format($price_start, 0, ',', '.')
                    . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
                $all_product = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->orderBy('product.product_id', 'desc')
                    ->get();
                $arrayProduct = array();
                $callFunction = new HomeClientController;
                foreach ($all_product as $product) {
                    $check_price = $callFunction->check_price_discount($product->product_id);
                    $price_now = number_format($check_price->price_now, 0, ',', '');
                    if ($price_start <= $price_now && $price_now <= $price_end) {
                        $product->price_now =  $price_now;
                        $arrayProduct[] = $product;
                    }
                }
                $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
                $data = $orderByArrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheogia.pdf');
                break;
            case "price_many":

                $price_start = $request->price_filter_start;
                $price_end = $request->price_filter_end;
                $string_title = 'Danh Sách Sản Phẩm Theo Giá " Từ ' . number_format($price_start, 0, ',', '.')
                    . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';

                $all_product = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->orderBy('product.product_id', 'desc')
                    ->get();
                $arrayProduct = array();
                $callFunction = new HomeClientController;
                foreach ($all_product as $product) {
                    $check_price = $callFunction->check_price_discount($product->product_id);
                    $price_now = number_format($check_price->price_now, 0, ',', '');
                    if ($price_start <= $price_now && $price_now <= $price_end) {
                        $product->price_now =  $price_now;
                        $arrayProduct[] = $product;
                    }
                }
                $orderByArrayProduct = collect($arrayProduct)->sortByDesc('price_now')->reverse()->toArray();
                $data = $orderByArrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheogiatuchon.pdf');

                break;
            case "rating":
                $string_title = 'Danh Sách Sản Phẩm Theo Đánh Giá "' . $level_filter . ' Sao"';
                $all_product = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->orderBy('product.product_id', 'desc')
                    ->get();
                $arrayProduct = array();
                $callFunction = new HomeClientController;
                foreach ($all_product as $product) {
                    $check_rating = $callFunction->info_rating_saled($product->product_id);
                    if ($check_rating->avg_rating >= $level_filter) {
                        $product->avg_rating =  $check_rating->avg_rating;
                        $arrayProduct[] = $product;
                    }
                }
                $orderByArrayProduct = collect($arrayProduct)->sortBy('avg_rating')->reverse()->toArray();
                $data = $orderByArrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheodanhgia.pdf');
                break;
            case "date":
                $string_title = 'Danh Sách Sản Phẩm Theo Ngày "' . date('d/m/Y', strtotime($level_filter)) . '"';
                $arrayProduct = array();
                $all_product = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->get();
                foreach ($all_product as $product) {
                    $date_create = date('Y-m-d', strtotime($product->create_at));
                    if ($level_filter == $date_create) {
                        $arrayProduct[] = $product;
                    }
                }
                $orderByArrayProduct = collect($arrayProduct)->sortByDesc('create_at')->reverse()->toArray();
                $data = $orderByArrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheongay.pdf');
                break;
            case "date_many":
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $string_title = 'Danh Sách Sản Phẩm " Từ Ngày ' . date('d/m/Y', strtotime($start_date)) . '
                        Đến Ngày ' . date('d/m/Y', strtotime($end_date)) . ' "';
                $arrayProduct = array();
                $all_product = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->get();
                foreach ($all_product as $product) {
                    $date_create = date('Y-m-d', strtotime($product->create_at));
                    if ($start_date <= $date_create && $date_create <= $end_date) {
                        $arrayProduct[] = $product;
                    }
                }
                $orderByArrayProduct = collect($arrayProduct)->sortByDesc('create_at')->reverse()->toArray();
                $data = $orderByArrayProduct;
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanphamtheonhieungay.pdf');
                break;
            default:
                $string_title = 'Danh Sách Sản Phẩm';
                $data = DB::table('product')
                    ->join('product_price', 'product_price.product_id', '=', 'product.product_id')
                    ->join('storage_product', 'storage_product.product_id', '=', 'product.product_id')
                    ->where('product_price.status', 1)
                    ->where('product.deleted_at', null)
                    ->orderBy('product.create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.product.view_print_pdf_product', [
                    'data' => $data,
                    'string_title' => $string_title,
                ]);
                return $pdf->download('danhsachsanpham.pdf');
        }
    }
}
