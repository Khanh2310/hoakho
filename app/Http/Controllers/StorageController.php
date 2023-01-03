<?php

namespace App\Http\Controllers;

use App\Admin_Action_Storage;
use App\Http\Controllers\Controller;
use App\Storage;
use App\Storage_Product;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorageController extends Controller
{
    //
    public function show_storage()
    {
        $all_storage = Storage::paginate(5);
        return view('admin.storage.all_storage', compact('all_storage'));
    }

    public function get_id_storage(Request $request)
    {
        $storage_id = $request->storage_id;
        $storage_name = Storage::find($storage_id);
        echo $storage_name->storage_name;
    }

    public function process_add_storage(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validation_storage($request);

        //CHECK NAME OF STORAGE
        $check_storage_name = Storage::where('storage_name', $request->storage_name)->first();
        if ($check_storage_name) {
            $request->session()->flash('check_storage_name', 'Tên kho hàng đã tồn tại');
            return redirect()->back();
        }

        $storage = new Storage();
        $storage->storage_name = $request->storage_name;
        $storage->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $reuslt_save = $storage->save();

        if ($reuslt_save) {
            // Action add storage
            $action_storage = new Admin_Action_Storage();
            $action_storage->admin_id = Session::get('admin_id');
            $action_storage->storage_id = $storage->storage_id;
            $action_storage->action_id = 1;
            $action_storage->action_message = "Thêm kho hàng";
            $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_storage->save();

            $request->session()->flash('success_add_storage', 'Thêm kho hàng thành công');
        }
        return redirect('admin/all_storage');
    }

    public function process_update_storage(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validation_storage($request);
        $storage_id = $request->storage_id;
        $storage = Storage::find($storage_id);

        //CHECK NAME OF STORAGE
        $check_storage_name = Storage::where('storage_name', $request->storage_name)->where('storage_id', '<>', $storage_id)->first();

        if ($check_storage_name) {
            $request->session()->flash('check_storage_name', 'Tên kho hàng đã tồn tại');
            return redirect('admin/all_storage');
        } else {
            $storage->storage_name = $request->storage_name;
            $storage->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $reuslt_save = $storage->save();

            if ($reuslt_save) {
                // Action update storage
                $this->action_update_storage($storage->storage_id);

                $request->session()->flash('success_update_storage', 'Sửa kho hàng thành công');
            }
            return redirect('admin/all_storage');
        }
    }

    public function action_update_storage($storage_id)
    {
        $action_storage = new Admin_Action_Storage();
        $action_storage->admin_id = Session::get('admin_id');
        $action_storage->storage_id = $storage_id;
        $action_storage->action_id = 2;
        $action_storage->action_message = "Sửa kho hàng";
        $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
        $action_storage->save();
    }
    public function update_storage_when_find(Request $request, $storage_id){
        $storage = Storage::find($storage_id);
        return view('admin.storage.view_update_storage_when_find', compact('storage'));
    }
    public function process_update_storage_when_find(Request $request){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validation_storage($request);
        $storage_id = $request->storage_id;
        $storage = Storage::find($storage_id);

        //CHECK NAME OF STORAGE
        $check_storage_name = Storage::where('storage_name', $request->storage_name)->where('storage_id', '<>', $storage_id)->first();

        if ($check_storage_name) {
            $request->session()->flash('check_storage_name', 'Tên kho hàng đã tồn tại');
            return redirect('admin/all_storage');
        } else {
            $storage->storage_name = $request->storage_name;
            $storage->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $reuslt_save = $storage->save();

            if ($reuslt_save) {
                // Action update storage
                $this->action_update_storage($storage->storage_id);

                $request->session()->flash('success_update_storage', 'Sửa kho hàng thành công');
            }
            return redirect('admin/all_storage');
        }
    }

    public function find_storage(Request $request)
    {
        $val_find_storage = $request->value_find;
        $all_storage = DB::table('storage')->where('deleted_at', null)->where('storage_name', 'LIKE', '%' . $val_find_storage . '%')->get();
        echo view('admin.storage.find_result_storage', compact('all_storage'));
    }

    public function process_delete_storage_when_find(Request $request, $storage_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product = Storage_Product::where('storage_id', $storage_id)->get();

        if (count($storage_product) > 0) {
            $request->session()->flash('check_delete_storage', 'Kho hàng đang còn sản phẩm');
            return redirect()->back();
        } else {
            $result_destroy = Storage::destroy($storage_id);
            if ($result_destroy) {
                // Action delete storage
                $action_storage = new Admin_Action_Storage();
                $action_storage->admin_id = Session::get('admin_id');
                $action_storage->storage_id = $storage_id;
                $action_storage->action_id = 3;
                $action_storage->action_message = "Xóa kho hàng";
                $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage->save();

                $request->session()->flash('success_delete_storage', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function view_recycle()
    {
        $recycle_item = Storage::onlyTrashed()->get();
        return view('admin.storage.all_recycle_storage', ['recycle_item' => $recycle_item]);
    }

    public function soft_delete(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_id = $request->storage_id;
        $storage_product = Storage_Product::where('storage_id', $storage_id)->get();

        if (count($storage_product) > 0) {
            $request->session()->flash('check_delete_storage', 'Kho hàng đang còn sản phẩm');
            return redirect()->back();
        } else {
            $result_delete = Storage::where('storage_id', $storage_id)->delete();

            if ($result_delete) {
                // Action delete storage
                $action_storage = new Admin_Action_Storage();
                $action_storage->admin_id = Session::get('admin_id');
                $action_storage->storage_id = $storage_id;
                $action_storage->action_id = 2;
                $action_storage->action_message = "Xóa kho hàng";
                $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage->save();

                $request->session()->flash('success_delete_soft_storage', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function re_delete(Request $request, $storage_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_name_recycle = Storage::onlyTrashed()->where('storage_id', $storage_id)->first();
        $storage_name_db = Storage::where('storage_name', $storage_name_recycle->storage_name)->get();

        if (count($storage_name_db) > 0) {
            $request->session()->flash('error_check_storage_name', 'Kho hàng đã tồn tại trong danh sách');
            $request->session()->flash('storage_id', $storage_name_recycle->storage_id);
            return redirect()->back();
        } else {
            $result_restore = Storage::withTrashed()->where('storage_id', $storage_id)->restore();

            if ($result_restore) {
                // Action recovery category
                $action_storage = new Admin_Action_Storage();
                $action_storage->admin_id = Session::get('admin_id');
                $action_storage->storage_id = $storage_id;
                $action_storage->action_id = 4;
                $action_storage->action_message = "Khôi phục kho hàng";
                $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage->save();

                $request->session()->flash('success_recovery_storage', 'Khôi phục thành công');
            }
            return redirect()->back();
        }
    }

    public function delete_forever(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_id = $request->storage_id_delete_forever;
        $result_forcedelete = Storage::withTrashed()->where('storage_id', $storage_id)->forceDelete();

        if ($result_forcedelete) {
            // Action delete forever storage
            $action_storage = new Admin_Action_Storage();
            $action_storage->admin_id = Session::get('admin_id');
            $action_storage->storage_id = $storage_id;
            $action_storage->action_id = 5;
            $action_storage->action_message = "Xóa vĩnh viễn kho hàng";
            $action_storage->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_storage->save();

            $request->session()->flash('success_delete_forever_storage', 'Xóa vĩnh viễn thành công');
        }
        return redirect()->back();
    }

    public function delete_recovery_forever_storage(Request $request, $storage_recovery_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Storage::withTrashed()->where('storage_id', $storage_recovery_id)->forceDelete();
        $request->session()->flash('success_delete_forever_storage', 'Loại sản phẩm đã được xóa khỏi thùng rác');
        return redirect()->back();
    }

    public function validation_storage(Request $request)
    {
        $request->validate([
            'storage_name' => 'required|max:100',
        ], [
            'storage_name.required' => 'Tên kho không được để trống',
            'storage_name.max' => 'Tên kho phải có độ dài tối đa là 100 ký tự'
        ]);
    }
}
