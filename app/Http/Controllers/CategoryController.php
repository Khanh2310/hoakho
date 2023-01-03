<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Admin_Action_Category;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function show_category()
    {
        $all_category = Category::paginate(5);
        return view('admin.category.all_category', ['all_category' => $all_category]);
    }

    public function add_category()
    {
        return view('admin.category.add_category');
    }

    public function process_add_category(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //check all
        $this->validation_category($request);

        //check name category
        $check_cate_name = Category::where('cate_name', $request->cate_name)->first();
        if ($check_cate_name) {
            $request->session()->flash('check_cate_name', 'Tên loại đã tồn tại');
            return redirect('admin/add_category');
        }

        $category = new Category();
        $category->cate_name = $request->cate_name;
        $category->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $get_image = $request->file('cate_image');
        if (isset($get_image)) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload', $new_image);
            $category->cate_image = $new_image;
        } else {
            $category->cate_image = ('no_image.png');
        }
        $result_save = $category->save();

        if ($result_save) {
            // Action add category
            $action_category = new Admin_Action_Category();
            $action_category->admin_id = Session::get('admin_id');
            $action_category->cate_id = $category->cate_id;
            $action_category->action_id = 1;
            $action_category->action_message = "Thêm loại sản phẩm";
            $action_category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_category->save();

            $request->session()->flash('success_category', 'Thêm loại sản phẩm thành công');
        }
        return redirect('admin/all_category');
    }

    public function update_category($cate_id)
    {
        $update_category = Category::find($cate_id);
        return view('admin.category.update_category', compact('update_category'));
    }

    public function process_update_category(Request $request, $cate_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validation_category($request);

        $category = Category::find($cate_id);

        //check name category
        $check_cate_name = Category::where('cate_name', $request->cate_name)->where('cate_id', '<>', $cate_id)->first();

        if ($check_cate_name) {
            $request->session()->flash('check_cate_name', 'Tên loại đã tồn tại');
            return redirect('admin/update_category/' . $cate_id);
        } else {
            $category->cate_name = $request->cate_name;
            $category->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $get_image = $request->file('cate_image');
            if (isset($get_image)) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('public/upload', $new_image);
                $category->cate_image = $new_image;
                $result_save = $category->save();

                if ($result_save) {
                    // Action update ategory
                    $this->action_update_cate($category->cate_id);
                    $request->session()->flash('success_category', 'Sửa loại sản phẩm thành công');
                }
                return redirect('admin/all_category');
            } else {
                $category->cate_image = $category->cate_image;
                $result_save = $category->save();

                if ($result_save) {
                    // Action update ategory
                    $this->action_update_cate($category->cate_id);
                    $request->session()->flash('success_category', 'Sửa loại sản phẩm thành công');
                }
                return redirect('admin/all_category');
            }
        }
    }

    public function action_update_cate($cate_id)
    {
        $action_category = new Admin_Action_Category();
        $action_category->admin_id = Session::get('admin_id');
        $action_category->cate_id = $cate_id;
        $action_category->action_id = 2;
        $action_category->action_message = "Sửa loại sản phẩm";
        $action_category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
        $action_category->save();
    }

    public function find_category(Request $request)
    {
        $val_find_cate = $request->value_find;
        $result_find = DB::table('category')->where('deleted_at', null)->where('cate_name', 'LIKE', '%' . $val_find_cate . '%')->get();
        echo view('admin.category.result_find_category', compact('result_find'));
    }

    public function process_delete_category(Request $request, $cate_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $cate_product = Product::where('category_id', $cate_id)->get();
        if (isset($cate_product)) {
            $request->session()->flash('error_category', 'Loại sản phẩm này đang còn hàng, không thể xóa!');
            return redirect()->back();
        } else {
            $result_delete = Category::destroy($cate_id);
            if ($result_delete) {
                // Action delete category
                $Action_Category = new Admin_Action_Category();
                $Action_Category->admin_id = Session::get('admin_id');
                $Action_Category->cate_id = $cate_id;
                $Action_Category->action_id = 3;
                $Action_Category->action_message = "Xóa loại sản phẩm";
                $Action_Category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $Action_Category->save();

                $request->session()->flash('success_category', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function view_recycle()
    {
        $recycle_item = Category::onlyTrashed()->get();
        return view('admin.category.all_recycle_item', ['recycle_item' => $recycle_item]);
    }

    public function re_delete(Request $request, $cate_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $cate_name_recycle = Category::onlyTrashed()->where('cate_id', $cate_id)->first();
        $cate_name_db = Category::where('cate_name', $cate_name_recycle->cate_name)->get();

        if (count($cate_name_db) > 0) {
            $request->session()->flash('error_check_cate_name', 'Loại sản phẩm đã tồn tại trong danh sách');
            $request->session()->flash('cate_id', $cate_name_recycle->cate_id);
            return redirect()->back();
        } else {
            $result_restore = Category::withTrashed()->where('cate_id', $cate_id)->restore();

            if ($result_restore) {
                // Action recovery category
                $Action_Category = new Admin_Action_Category();
                $Action_Category->admin_id = Session::get('admin_id');
                $Action_Category->cate_id = $cate_id;
                $Action_Category->action_id = 4;
                $Action_Category->action_message = "Khôi phục loại sản phẩm";
                $Action_Category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $Action_Category->save();

                $request->session()->flash('success_recovery_category', 'Khôi phục thành công');
            }
            return redirect()->back();
        }
    }

    public function delete_forever(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $cate_id = $request->category_id_delete_forever;
        $result_forcedelete = Category::withTrashed()->where('cate_id', $cate_id)->forceDelete();

        if ($result_forcedelete) {
            // Action delete forever category
            $Action_Category = new Admin_Action_Category();
            $Action_Category->admin_id = Session::get('admin_id');
            $Action_Category->cate_id = $cate_id;
            $Action_Category->action_id = 5;
            $Action_Category->action_message = "Xóa vĩnh viễn loại sản phẩm";
            $Action_Category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $Action_Category->save();

            $request->session()->flash('success_delete_forever_category', 'Xóa vĩnh viễn thành công');
        }
        return redirect()->back();
    }

    public function delete_recovery_forever(Request $request, $cate_recovery_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::withTrashed()->where('cate_id', $cate_recovery_id)->forceDelete();
        $request->session()->flash('success_delete_forever_category', 'Loại sản phẩm đã được xóa khỏi thùng rác');
        return redirect()->back();
    }

    public function soft_delete(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $cate_id = $request->cate_id;
        $cate_product = Product::where('category_id', $cate_id)->get();
        if (count($cate_product) > 0) {
            $request->session()->flash('error_category', 'Loại sản phẩm này đang còn hàng, không thể xóa!');
            return redirect()->back();
        } else {
            $result_delete = Category::destroy($cate_id);
            if ($result_delete) {
                // Action delete category
                $Action_Category = new Admin_Action_Category();
                $Action_Category->admin_id = Session::get('admin_id');
                $Action_Category->cate_id = $cate_id;
                $Action_Category->action_id = 3;
                $Action_Category->action_message = "Xóa loại sản phẩm";
                $Action_Category->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $Action_Category->save();

                $request->session()->flash('success_category', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function validation_category(Request $request)
    {
        $request->validate([
            'cate_name' => 'required|max:100',
        ], [
            'cate_name.required' => 'Tên không được để trống',
            'cate_name.max' => 'Tên có độ dài tối đa là 100 ký tự',
        ]);
    }
}
