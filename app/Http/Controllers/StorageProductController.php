<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Admin_Action_Storage_Product;
use App\Http\Controllers\Controller;
use App\ImageProduct;
use App\Import_Storage_Product;
use App\Product;
use App\ProductPrice;
use App\Storage;
use App\Storage_Product;
use Carbon\Carbon;
use Session;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorageProductController extends Controller
{
    //
    public function all_storage_product(Request $request, $storage_id)
    {
        $all_storage_product = Storage_Product::where('storage_id', $storage_id)->paginate(5);
        $all_product = DB::table('product')->get();

        $storage = Storage::where('storage_id', $storage_id)->first();
        $storage_name = $storage->storage_name;

        return view('admin.storage_product.all_storage_product', compact('all_storage_product', 'all_product', 'storage_id', 'storage_name'));
    }

    public function update_storage_product(Request $request, $storage_product_id)
    {
        $storage_product = Storage_Product::find($storage_product_id);
        $storage_id = $storage_product->storage_id;
        $all_product = DB::table('product')->get();

        return view('admin.storage_product.update_storage_product', compact('storage_product', 'all_product', 'storage_id'));
    }

    public function process_update_storage_product(Request $request, $storage_product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product = Storage_Product::find($storage_product_id);

        if ($request->total_quantity_product > $storage_product->total_quantity_product) {
            $request->session()->flash('error_check_storage_product_quantity', 'Số lượng không được lớn hơn số lượng hiện tại');
            return redirect()->back();
        }
        if ($request->total_quantity_product < 0) {
            $request->session()->flash('error_check_storage_product_quantity', 'Số lượng nhập phải lớn hơn 0');
            return redirect()->back();
        }
        if ($request->total_quantity_product == null) {
            $request->session()->flash('error_check_storage_product_null', 'Số lượng nhập không được bỏ trống');
            return redirect()->back();
        }

        $result_save = DB::table('storage_product')->where('storage_product_id', $storage_product_id)->update([
            'total_quantity_product' => $request->total_quantity_product,
            'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        if ($result_save) {
            // Action update storage product
            $action_storage_product = new Admin_Action_Storage_Product();
            $action_storage_product->admin_id = Session::get('admin_id');
            $action_storage_product->storage_product_id = $storage_product->storage_product_id;
            $action_storage_product->action_id = 2;
            $action_storage_product->action_message = "Cập nhật số lượng sản phẩm";
            $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_storage_product->save();

            $request->session()->flash('success_update_storage_product', 'Sửa kho sản phẩm thành công');
        }
        return redirect('admin/all_storage_product/' . $storage_product->storage_id);
    }

    public function import_storage_product($storage_product_id)
    {
        $storage_product = Storage_Product::find($storage_product_id);
        $storage_id = $storage_product->storage_id;
        $product = DB::table('product')
        ->where('product_id', $storage_product->product_id)->first();

        return view('admin.storage_product.import_storage_product', compact('storage_product', 'product', 'storage_id'));
    }

    public function process_import_storage_product(Request $request, $storage_product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product = Storage_Product::find($storage_product_id);

        if ($request->total_quantity_product <= 0) {
            $request->session()->flash('error_check_storage_product_quantity', 'Số lượng nhập phải lớn hơn 0');
            return redirect()->back();
        }

        $total_quantity_new = $request->total_quantity_product + $storage_product->total_quantity_product;

        $check_import = Import_Storage_Product::create([
            'admin_id' => Session::get('admin_id'),
            'quantity_import' => $request->total_quantity_product,
            'storage_product_id' => $storage_product_id,
            'quantity_current' => $storage_product->total_quantity_product,
            'quantity_total' => $total_quantity_new,
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        if ($check_import) {
            $result_save = DB::table('storage_product')->where('storage_product_id', $storage_product_id)->update([
                'total_quantity_product' => $total_quantity_new,
            ]);

            if ($result_save) {
                // Action add storage product
                $action_storage_product = new Admin_Action_Storage_Product();
                $action_storage_product->admin_id = Session::get('admin_id');
                $action_storage_product->storage_product_id = $storage_product->storage_product_id;
                $action_storage_product->action_id = 1;
                $action_storage_product->action_message = "Nhập hàng";
                $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage_product->save();
            }
        }
        $request->session()->flash('success_import_storage_product', 'Nhập kho sản phẩm thành công');
        return redirect('admin/all_storage_product/' . $storage_product->storage_id);
    }

    public function find_storage_product(Request $request)
    {
        $value_find = $request->value_find;
        $value_storage_id = $request->value_storage_id;
        $all_storage_product = DB::table('storage_product')->where('deleted_at', null)->where('storage_id', $value_storage_id)->get();
        $all_product = DB::table('product')->where('product_name', 'LIKE', '%' . $value_find . '%')->get();
        echo view('admin.storage_product.result_find_storage_product', compact('all_storage_product', 'all_product'));
    }

    public function history_storage_product($storage_product_id)
    {
        $history_storage_product = Import_Storage_Product::where('storage_product_id', $storage_product_id)->paginate(5);
        $storage_product = Storage_Product::where('storage_product_id', $storage_product_id)->first();
        $storage_id = $storage_product->storage_id;
        $all_product = DB::table('product')->get();
        $all_admin = Admin::all();
        $quantity_total = $storage_product->total_quantity_product;

        return view('admin.storage_product.history_storage_product', compact('history_storage_product', 'all_product', 'storage_product', 'all_admin', 'storage_id', 'quantity_total'));
    }

    public function process_delete_storage_product(Request $request, $storage_product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product = Storage_Product::where('storage_product_id', $storage_product_id)->first();
        $product_id = $storage_product->product_id;

        if ($storage_product->total_quantity_product > 0) {
            $request->session()->flash('error_delete_soft_storage_product', 'Sản phẩm chưa hết hàng không thể xóa');
            return redirect()->back();
        } else {
            Product::where('product_id', $product_id)->delete();
            $result_destroy = Storage_Product::destroy($storage_product_id);
            if ($result_destroy) {
                // Action delete storage product
                $action_storage_product = new Admin_Action_Storage_Product();
                $action_storage_product->admin_id = Session::get('admin_id');
                $action_storage_product->storage_product_id = $storage_product_id;
                $action_storage_product->action_id = 3;
                $action_storage_product->action_message = "Xóa kho sản phẩm";
                $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage_product->save();

                $request->session()->flash('success_delete_storage_product', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function view_recycle($storage_id)
    {
        $recycle_item = Storage_Product::onlyTrashed()->get();
        $all_product = DB::table('product')->get();

        return view('admin.storage_product.all_recycle_storage_product', compact('recycle_item', 'all_product', 'storage_id'));
    }

    public function soft_delete(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product_id = $request->storage_product_id;
        $storage_product = Storage_Product::where('storage_product_id', $storage_product_id)->first();
        $product_id = $storage_product->product_id;

        if ($storage_product->total_quantity_product > 0) {
            $request->session()->flash('error_delete_soft_storage_product', 'Sản phẩm chưa hết hàng không thể xóa');
            return redirect()->back();
        } else {
            Product::where('product_id', $product_id)->delete();
            $result_delete = Storage_Product::where('storage_product_id', $storage_product_id)->delete();

            if ($result_delete) {
                // Action delete storage product
                $action_storage_product = new Admin_Action_Storage_Product();
                $action_storage_product->admin_id = Session::get('admin_id');
                $action_storage_product->storage_product_id = $storage_product_id;
                $action_storage_product->action_id = 3;
                $action_storage_product->action_message = "Xóa sản phẩm trong kho";
                $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $action_storage_product->save();
                $request->session()->flash('success_delete_soft_storage_product', 'Xóa thành công');
            }
            return redirect()->back();
        }
    }

    public function re_delete(Request $request, $storage_product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product = Storage_Product::onlyTrashed()->where('storage_product_id', $storage_product_id)->first();
        $product_id = $storage_product->product_id;

        Product::withTrashed()->where('product_id', $product_id)->restore();
        $result_restore = Storage_Product::withTrashed()->where('storage_product_id', $storage_product_id)->restore();

        if ($result_restore) {
            // Action recovery storage product
            $action_storage_product = new Admin_Action_Storage_Product();
            $action_storage_product->admin_id = Session::get('admin_id');
            $action_storage_product->storage_product_id = $storage_product_id;
            $action_storage_product->action_id = 4;
            $action_storage_product->action_message = "Khôi phục sản phẩm từ kho";
            $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_storage_product->save();
            $request->session()->flash('success_recovery_storage_product', 'Khôi phục thành công');
        }
        return redirect()->back();
    }
    public function delete_forever(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $storage_product_id = $request->storage_product_id_delete_forever;
        $storage_product = Storage_Product::withTrashed()->where('storage_product_id', $storage_product_id)->first();
        $product_id = $storage_product->product_id;

        ProductPrice::withTrashed()->where('product_id', $product_id)->forceDelete();
        ImageProduct::withTrashed()->where('product_id', $product_id)->forceDelete();
        Product::withTrashed()->where('product_id', $product_id)->forceDelete();
        $result_forcedelete = Storage_Product::withTrashed()->where('storage_product_id', $storage_product_id)->forceDelete();

        if ($result_forcedelete) {
            // Action delete forever storage product
            $action_storage_product = new Admin_Action_Storage_Product();
            $action_storage_product->admin_id = Session::get('admin_id');
            $action_storage_product->storage_product_id = $storage_product_id;
            $action_storage_product->action_id = 5;
            $action_storage_product->action_message = "Xóa vĩnh viễn kho sản phẩm";
            $action_storage_product->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $action_storage_product->save();
            $request->session()->flash('success_delete_forever_storage_product', 'Xóa vĩnh viễn thành công');
        }
        return redirect()->back();
    }

    public function filter_storage_product_quantity_choose(Request $request)
    {
        $storage_id = $request->storageId;
        $all_product = Product::all();
        $storage_product_quantity_choose = $request->radioProductQuantity;
        $type_filter = 'choose_quantity';
        $level_filter = $storage_product_quantity_choose;
        $quantity_start = 0;
        $quantity_end = 0;
        if ($storage_product_quantity_choose == 1) {
            $quantity_start = 0;
            $quantity_end = 50;
        } else if ($storage_product_quantity_choose == 2) {
            $quantity_start = 51;
            $quantity_end = 100;
        } else if ($storage_product_quantity_choose == 3) {
            $quantity_start = 101;
            $quantity_end = 150;
        } else if ($storage_product_quantity_choose == 4) {
            $quantity_start = 151;
            $quantity_end = 200;
        }
        $string_title = 'Theo Số Lượng Sản Phẩm " Từ ' . $quantity_start . ' Đến ' . $quantity_end . '"';
        $all_storage_product = Storage_Product::where('storage_id', $storage_id)
            ->where('total_quantity_product', '>=', $quantity_start)
            ->where('total_quantity_product', '<=', $quantity_end)
            ->orderBy('total_quantity_product', 'desc')
            ->get();
        echo view('admin.storage_product.view_filter_storage_product', compact(
            'type_filter',
            'level_filter',
            'storage_id',
            'all_product',
            'all_storage_product',
            'string_title'
        ));
    }

    public function filter_storage_product_quantity_cus_option(Request $request)
    {
        $storage_id = $request->storageId;
        $all_product = Product::all();
        $type_filter = 'cus_quantity';
        $level_filter = '';
        $quantity_start = $request->quantityStart;
        $quantity_end = $request->quantityEnd;
        $string_title = 'Theo Số Lượng Sản Phẩm " Từ ' . $quantity_start . ' Đến ' . $quantity_end . '"';
        $all_storage_product = Storage_Product::where('storage_id', $storage_id)
            ->where('total_quantity_product', '>=', $quantity_start)
            ->where('total_quantity_product', '<=', $quantity_end)
            ->orderBy('total_quantity_product', 'desc')
            ->get();
        echo view('admin.storage_product.view_filter_storage_product', compact(
            'type_filter',
            'level_filter',
            'storage_id',
            'all_product',
            'all_storage_product',
            'string_title',
            'quantity_start',
            'quantity_end',
        ));
    }

    public function print_pdf_storage_product(Request $request)
    {
        $all_product = Product::all();
        $storage_id = $request->storage_id;
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;

        switch ($type_filter) {
            case "choose_quantity":
                $quantity_start = 0;
                $quantity_end = 0;
                if ($level_filter == 1) {
                    $quantity_start = 0;
                    $quantity_end = 50;
                } else if ($level_filter == 2) {
                    $quantity_start = 51;
                    $quantity_end = 100;
                } else if ($level_filter == 3) {
                    $quantity_start = 101;
                    $quantity_end = 150;
                } else if ($level_filter == 4) {
                    $quantity_start = 151;
                    $quantity_end = 200;
                }
                $string_title = 'Danh Sách Kho Sản Phẩm Theo Số Lượng Sản Phẩm " Từ ' . $quantity_start . ' Đến ' . $quantity_end . '"';
                $all_storage_product = Storage_Product::where('storage_id', $storage_id)
                    ->where('total_quantity_product', '>=', $quantity_start)
                    ->where('total_quantity_product', '<=', $quantity_end)
                    ->orderBy('total_quantity_product', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.storage_product.view_print_pdf_storage_product', compact('all_product', 'all_storage_product', 'string_title'));
                return $pdf->download('danhsachkhosanphamtheosoluong.pdf');
                break;
            case "cus_quantity":
                $all_product = Product::all();
                $type_filter = 'cus_quantity';
                $level_filter = '';
                $quantity_start = $request->quantity_start;
                $quantity_end = $request->quantity_end;
                $string_title = 'Theo Số Lượng Sản Phẩm " Từ ' . $quantity_start . ' Đến ' . $quantity_end . '"';
                $all_storage_product = Storage_Product::where('storage_id', $storage_id)
                    ->where('total_quantity_product', '>=', $quantity_start)
                    ->where('total_quantity_product', '<=', $quantity_end)
                    ->orderBy('total_quantity_product', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.storage_product.view_print_pdf_storage_product', compact(
                    'type_filter',
                    'level_filter',
                    'storage_id',
                    'all_product',
                    'all_storage_product',
                    'string_title'
                ));
                return $pdf->download('danhsachkhohangtheosoluongtuchon.pdf');
                break;
            default:
                $string_title = 'Danh Sách Kho Sản Phẩm';
                $all_storage_product = Storage_Product::where('storage_id', $storage_id)->get();
                $pdf = PDF::loadView('admin.storage_product.view_print_pdf_storage_product', compact('all_product', 'all_storage_product', 'string_title'));
                return $pdf->download('danhsachkhosanpham.pdf');
        }
    }

    public function print_pdf_history_storage_product(Request $request)
    {
        $storage_product_id = $request->storage_product_id;
        $product_id = $request->product_id;

        $history_storage_product = Import_Storage_Product::where('storage_product_id', $storage_product_id)->get();

        $all_admin = Admin::all();

        $storage_product = Storage_Product::where('storage_product_id', $storage_product_id)->first();
        $quantity_total = $storage_product->total_quantity_product;
        $product = Product::where('product_id', $product_id)->first();
        $product_name = $product->product_name;

        $string_title = 'Danh Sách Lịch Sử Nhập Hàng - "' . $product_name . '"';
        $pdf = PDF::loadView('admin.storage_product.view_print_pdf_history_storage_product', compact('quantity_total', 'all_admin', 'history_storage_product', 'string_title'));
        return $pdf->download('danhsachlichsunhaphang.pdf');
    }
}
