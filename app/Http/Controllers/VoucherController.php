<?php

namespace App\Http\Controllers;

use App\Admin_Action_Voucher;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductPrice;
use App\Voucher;
use App\Admin;
use Carbon\Carbon;
use Session;
use PDF;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    //
    public static function unique_product($product_id)
    {
        $count_voucher = Voucher::where('product_id', $product_id)->get();
        if (count($count_voucher) > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function all_product_voucher()
    {
        $all_voucher = Voucher::all();
        $all_product = Product::all();
        return view('admin.voucher.all_product_voucher', compact('all_product', 'all_voucher'));
    }

    public function all_voucher($product_id)
    {
        $all_voucher = Voucher::where('product_id', $product_id)->orderBy('voucher_id', 'desc')->paginate(10);
        $product = Product::where('product_id', $product_id)->first();
        $all_admin = Admin::all();
        $product_name = $product->product_name;
        $product_id = $product->product_id;
        return view('admin.voucher.all_voucher', compact('all_voucher', 'product_name', 'product_id', 'all_admin'));
    }
    public function detail_voucher(Request $request, $voucher_id)
    {
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $product_id = $voucher->product_id;
        $product = Product::where('product_id', $product_id)->first();
        return view('admin.voucher.detail_voucher', compact('voucher', 'product'));
    }
    public function add_voucher()
    {
        $all_product = Product::all();
        return view('admin.voucher.add_voucher', compact('all_product'));
    }

    public function add_product_voucher($product_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $product = Product::find($product_id);
        return view('admin.voucher.add_product_voucher', compact('product'));
    }

    public function process_add_voucher(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validate_voucher($request);

        $voucher_code = $request->voucher_code;
        $voucher_name = $request->voucher_name;
        $product_id = $request->product_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $voucher_amount = $request->voucher_amount;
        $voucher_quantity = $request->voucher_quantity;
        $voucher_type = $request->voucher_type;

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $product = ProductPrice::where('product_id', $product_id)->where('status', 1)->first();
        $product_price = $product->price;

        $check_voucher_code = Voucher::where('voucher_code', $voucher_code)->first();

        if ($check_voucher_code) {
            $request->session()->flash('voucher_code', 'M?? voucher ???? t???n t???i');
            return redirect()->back();
        }
        if ($start_date < date("Y-m-d\TH:i", strtotime($date_now))) {
            $request->session()->flash('start_date', 'Ng??y b???t ?????u kh??ng ???????c nh??? h??n ng??y hi???n t???i');
            return redirect()->back();
        }
        if ($end_date <= $start_date) {
            $request->session()->flash('end_date', 'Ng??y k???t th??c ph???i l???n h??n ng??y b???t ?????u');
            return redirect()->back();
        }
        if ($voucher_quantity < 0) {
            $request->session()->flash('check_voucher_quantity', 'S??? l?????ng kh??ng h???p l???');
            return redirect()->back();
        }

        $voucher_new = new Voucher();
        $voucher_new->voucher_code = strtoupper($voucher_code);
        $voucher_new->voucher_name = $voucher_name;
        $voucher_new->product_id = $product_id;
        $voucher_new->start_date = $start_date;
        $voucher_new->end_date = $end_date;
        $voucher_new->voucher_quantity = $voucher_quantity;

        $product = ProductPrice::where('product_id', $product_id)->where('status', 1)->first();
        $product_price = $product->price;

        if ($voucher_type == 1) {
            if ($voucher_amount < 1000) {
                $request->session()->flash('voucher_amount', 'M???nh gi?? kh??ng ???????c nh??? h??n 1.0000??');
                return redirect()->back();
            }
            if ($voucher_amount > $product_price) {
                $request->session()->flash('voucher_amount', 'M???nh gi?? kh??ng ???????c l???n h??n ' . number_format($product_price, 0, ',', '.') . '??');
                return redirect()->back();
            }
            $voucher_new->voucher_amount = $voucher_amount;
        } else {
            if ($voucher_amount < 1 || $voucher_amount > 100) {
                $request->session()->flash('voucher_amount', 'M???nh gi?? ph???i t??? 1-100%');
                return redirect()->back();
            } else {
                $voucher_new->voucher_amount = $product_price * ($voucher_amount / 100);
            }
        }
        $voucher_new->status = 1;
        $result_voucher_new = $voucher_new->save();

        if ($result_voucher_new) {
            $admin_action_voucher = new Admin_Action_Voucher();
            $admin_action_voucher->admin_id = Session::get('admin_id');
            $admin_action_voucher->voucher_id = $voucher_new->voucher_id;
            $admin_action_voucher->action_id = 1;
            $admin_action_voucher->action_message = 'Th??m voucher';
            $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_voucher->save();

            $request->session()->flash('add_voucher_success', 'Thi???t l???p voucher cho s???n ph???m th??nh c??ng');
            return redirect('admin/all_voucher/' . $product_id);
        }
    }

    public function update_voucher($voucher_id)
    {
        $all_product = Product::all();
        $voucher = DB::table('voucher')->where('voucher_id', $voucher_id)->first();
        return view('admin.voucher.update_voucher', compact('voucher', 'all_product'));
    }

    public function process_update_voucher(Request $request, $voucher_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->validate_voucher($request);

        $voucher_code = $request->voucher_code;
        $voucher_name = $request->voucher_name;
        $product_id = $request->product_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $voucher_amount = $request->voucher_amount;
        $voucher_quantity = $request->voucher_quantity;

        $product = ProductPrice::where('product_id', $product_id)->where('status', 1)->first();
        $product_price = $product->price;

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');

        $check_voucher_code_first = Voucher::where('voucher_id', $voucher_id)->first();
        $check_voucher_code_second = Voucher::where('voucher_code', $voucher_code)->first();

        if ($check_voucher_code_first->voucher_code == $voucher_code) {
            $voucher_code = $check_voucher_code_first->voucher_code;
        } else {
            if ($check_voucher_code_second) {
                $request->session()->flash('voucher_code', 'M?? voucher ???? t???n t???i');
                return redirect()->back();
            }
        }
        if ($start_date < date("Y-m-d\TH:i", strtotime($date_now))) {
            $request->session()->flash('start_date', 'Ng??y b???t ?????u kh??ng ???????c nh??? h??n ng??y hi???n t???i');
            return redirect()->back();
        }
        if ($end_date <= $start_date) {
            $request->session()->flash('end_date', 'Ng??y k???t th??c ph???i l???n h??n ng??y b???t ?????u');
            return redirect()->back();
        }
        if ($voucher_quantity < 0) {
            $request->session()->flash('check_voucher_quantity', 'S??? l?????ng kh??ng h???p l???');
            return redirect()->back();
        }

        $voucher_update = Voucher::where('voucher_id', $voucher_id)->first();
        $voucher_update->voucher_code = strtoupper($voucher_code);
        $voucher_update->voucher_name = $voucher_name;
        $voucher_update->product_id = $product_id;
        $voucher_update->start_date = $start_date;
        $voucher_update->end_date = $end_date;
        $voucher_update->voucher_quantity = $voucher_quantity;

        $product = ProductPrice::where('product_id', $product_id)->where('status', 1)->first();
        $product_price = $product->price;

        if ($voucher_amount < 1000) {
            $request->session()->flash('voucher_amount', 'M???nh gi?? kh??ng ???????c nh??? h??n 1.000??');
            return redirect()->back();
        } elseif ($voucher_amount > $product_price) {
            $request->session()->flash('voucher_amount', 'M???nh gi?? kh??ng ???????c l???n h??n ' . number_format($product_price, 0, ',', '.') . '??');
            return redirect()->back();
        } else {
            $voucher_update->voucher_amount = $voucher_amount;
        }
        $result_voucher_update = $voucher_update->save();

        if ($result_voucher_update) {
            $admin_action_voucher = new Admin_Action_Voucher();
            $admin_action_voucher->admin_id = Session::get('admin_id');
            $admin_action_voucher->voucher_id = $voucher_id;
            $admin_action_voucher->action_id = 2;
            $admin_action_voucher->action_message = 'S???a voucher';
            $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_voucher->save();

            $request->session()->flash('update_voucher_success', 'Thi???t l???p l???i voucher cho s???n ph???m th??nh c??ng');
            return redirect('admin/all_voucher/' . $product_id);
        }
    }

    public function get_voucher_id(Request $request)
    {
        $voucher_id = $request->voucher_id;
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $product_id = $voucher->product_id;
        $product = Product::where('product_id', $product_id)->first();
        echo view('admin.voucher.modal_detail_voucher', compact('voucher', 'product'));
    }

    public function find_product_voucher(Request $request)
    {
        $val_find_product_voucher = $request->value_find;
        $all_voucher = Voucher::all();
        $all_product_voucher = Product::where('product_name', 'LIKE', '%' . $val_find_product_voucher . '%')->get();
        $count_result = DB::table('product')
            ->join('voucher', 'voucher.product_id', '=', 'product.product_id')
            ->where('product.product_name', 'LIKE', '%' . $val_find_product_voucher . '%')
            ->get();
        echo view('admin.voucher.find_result_product_voucher', compact('count_result', 'all_product_voucher', 'all_voucher'));
        // echo $val_find_product_voucher;
    }

    public function find_voucher(Request $request)
    {
        $val_find_voucher = $request->value_find;
        $product_id = $request->product_id;
        $all_voucher_find = Voucher::where('voucher_name', 'LIKE', '%' . $val_find_voucher . '%')
            ->orWhere('voucher_code', 'LIKE', '%' . $val_find_voucher . '%')
            ->get();
        $arrayVoucher = [];
        foreach ($all_voucher_find as $voucher) {
            if ($voucher->product_id == $product_id) {
                $arrayVoucher[] = $voucher;
            }
        }
        $all_voucher = array_reverse($arrayVoucher);
        echo view('admin.voucher.find_result_voucher', compact('all_voucher'));
    }

    public function all_recycle($product_id)
    {
        $recycle_item = Voucher::onlyTrashed()->where('product_id', $product_id)->get();
        return view('admin.voucher.all_recycle', compact('recycle_item', 'product_id'));
    }

    public function soft_delete_voucher(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $voucher_id = $request->voucher_id;
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');

        if ($voucher->start_date <= $date_now && $date_now <= $voucher->end_date && $voucher->voucher_quantity) {
            $request->session()->flash('error_delete_soft_voucher', 'Voucher ??ang ??p d???ng kh??ng th??? x??a');
            return redirect()->back();
        } else if ($voucher->start_date > $date_now) {
            $request->session()->flash('error_delete_soft_voucher', 'Voucher ch??a ??p d???ng kh??ng th??? x??a');
            return redirect()->back();
        } else {
            Voucher::where('voucher_id', $voucher_id)->delete();
            $request->session()->flash('success_delete_soft_voucher', 'X??a th??nh c??ng');

            // Action delete storage product
            $admin_action_voucher = new Admin_Action_Voucher();
            $admin_action_voucher->admin_id = Session::get('admin_id');
            $admin_action_voucher->voucher_id = $voucher_id;
            $admin_action_voucher->action_id = 3;
            $admin_action_voucher->action_message = "X??a voucher";
            $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_voucher->save();
            return redirect()->back();
        }
    }
    public function delete_voucher_when_find(Request $request, $voucher_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();

        $date_now = Carbon::now('Asia/Ho_Chi_Minh');

        if ($voucher->start_date <= $date_now && $date_now <= $voucher->end_date && $voucher->voucher_quantity) {
            $request->session()->flash('error_delete_soft_voucher', 'Voucher ??ang ??p d???ng kh??ng th??? x??a');
            return redirect()->back();
        } else if ($voucher->start_date > $date_now) {
            $request->session()->flash('error_delete_soft_voucher', 'Voucher ch??a ??p d???ng kh??ng th??? x??a');
            return redirect()->back();
        } else {
            Voucher::where('voucher_id', $voucher_id)->delete();
            $request->session()->flash('success_delete_soft_voucher', 'X??a th??nh c??ng');

            // Action delete storage product
            $admin_action_voucher = new Admin_Action_Voucher();
            $admin_action_voucher->admin_id = Session::get('admin_id');
            $admin_action_voucher->voucher_id = $voucher_id;
            $admin_action_voucher->action_id = 3;
            $admin_action_voucher->action_message = "X??a voucher";
            $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_voucher->save();
            return redirect()->back();
        }
    }
    public function delete_forever(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $voucher_id = $request->voucher_id;

        $result_delete = Voucher::withTrashed()->where('voucher_id', $voucher_id)->forceDelete();

        if ($result_delete) {
            $admin_action_voucher = new Admin_Action_Voucher();
            $admin_action_voucher->admin_id = Session::get('admin_id');
            $admin_action_voucher->voucher_id = $voucher_id;
            $admin_action_voucher->action_id = 5;
            $admin_action_voucher->action_message = "X??a v??nh vi???n voucher";
            $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
            $admin_action_voucher->save();
            $request->session()->flash('success_delete_forever_voucher', 'X??a v??nh vi???n th??nh c??ng');
            return redirect()->back();
        }
    }

    public function re_delete(Request $request, $voucher_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $voucher = Voucher::onlyTrashed()->where('voucher_id', $voucher_id)->first();
        $voucher_code_db = Voucher::where('voucher_code', $voucher->voucher_code)->get();

        if (count($voucher_code_db) > 0) {
            $request->session()->flash('error_check_voucher_code', 'M?? voucher ???? t???n t???i trong danh s??ch');
            return redirect()->back();
        } else {
            $result_recovery = Voucher::withTrashed()->where('voucher_id', $voucher_id)->restore();
            if ($result_recovery) {
                $admin_action_voucher = new Admin_Action_Voucher();
                $admin_action_voucher->admin_id = Session::get('admin_id');
                $admin_action_voucher->voucher_id = $voucher_id;
                $admin_action_voucher->action_id = 4;
                $admin_action_voucher->action_message = "Kh??i ph???c voucher";
                $admin_action_voucher->action_time = Carbon::now('Asia/Ho_Chi_Minh');
                $admin_action_voucher->save();

                $request->session()->flash('success_recovery_voucher', 'Kh??i ph???c th??nh c??ng');
                return redirect()->back();
            }
        }
    }

    public function validate_voucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|min:5|max:20|alpha_dash|regex:/^([a-z A-Z 0-9]+)$/',
            'voucher_name' => 'required|min:5|max:100',
            'product_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'voucher_amount' => 'required',
            'voucher_quantity' => 'required|integer',
        ], [
            'voucher_code.required' => 'M?? voucher kh??ng ???????c ????? tr???ng',
            'voucher_code.alpha_dash' => 'M?? voucher kh??ng h???p l???',
            'voucher_code.min' => 'M?? voucher ph???i l???n h??n 5 k?? t???',
            'voucher_code.max' => 'M?? voucher ph???i nh??? h??n ho???c b???ng 20 k?? t???',
            'voucher_code.regex' => 'M?? voucher kh??ng h???p l???',
            'product_id.required' => 'Vui l??ng ch???n s???n ph???m cho voucher',
            'start_date.required' => 'Vui l??ng ch???n ng??y b???t ?????u',
            'end_date.required' => 'Vui l??ng ch???n ng??y k???t th??c',
            'voucher_name.required' => 'T??n voucher kh??ng ???????c ????? tr???ng',
            'voucher_name.min' => 'T??n voucher ph???i l???n h??n 5 k?? t???',
            'voucher_name.max' => 'T??n voucher ph???i nh??? h??n ho???c b???ng 10 k?? t???',
            'voucher_amount.required' => 'Vui l??ng nh???p m???nh gi??',
            'voucher_quantity.required' => 'Vui l??ng nh???p s??? l?????ng',
            'voucher_quantity.integer' => 'S??? l?????ng kh??ng h???p l???',
        ]);
    }

    public function filter_voucher_follow_status_apply(Request $request)
    {
        $product_id = $request->productId;
        $type_filter = 'apply';
        $level_filter = '';
        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $all_voucher = Voucher::where('product_id', $product_id)
            ->where('start_date', '<=', $date_now)
            ->where('end_date', '>=', $date_now)
            ->where('voucher_quantity', '>', 0)
            ->orderBy('voucher_id', 'desc')
            ->get();
        $string_title = ' Theo Tr???ng Th??i ??ang ??p D???ng';
        $product = Product::where('product_id', $product_id)->first();
        $product_name = $product->product_name;
        echo view('admin.voucher.view_filter_voucher', compact('all_voucher', 'product_name', 'product_id', 'string_title', 'type_filter', 'level_filter'));
    }

    public function filter_voucher_follow_status_unapply(Request $request)
    {
        $product_id = $request->productId;
        $type_filter = 'unapply';
        $level_filter = '';
        $date_now = Carbon::now('Asia/Ho_Chi_Minh');
        $all_voucher = Voucher::where('product_id', $product_id)
            ->where('end_date', '<', $date_now)
            ->orWhere('voucher_quantity', '=', 0)
            ->orderBy('voucher_id', 'desc')
            ->get();
        $string_title = ' Theo Tr???ng Th??i Ng??ng ??p D???ng';
        $product = Product::where('product_id', $product_id)->first();
        $product_name = $product->product_name;
        echo view('admin.voucher.view_filter_voucher', compact('all_voucher', 'product_name', 'product_id', 'string_title', 'type_filter', 'level_filter'));
    }

    public function filter_voucher_follow_date_single(Request $request)
    {
        $product_id = $request->productId;
        $date = $request->date;
        $date_filter = date('Y-m-d', strtotime($date));

        $type_filter = 'date';
        $level_filter = $date_filter;

        $string_title = ' Theo Ng??y "' . date('d/m/Y', strtotime($date)) . '"';
        $all_voucher_db = Voucher::where('product_id', $product_id)->get();
        $product = Product::where('product_id', $product_id)->first();
        $product_name = $product->product_name;

        $arrayVoucher = [];
        foreach ($all_voucher_db as $voucher) {
            $created_at = date('Y-m-d', strtotime($voucher->created_at));
            if ($created_at == $date_filter) {
                $arrayVoucher[] = $voucher;
            }
        }
        $all_voucher = array_reverse($arrayVoucher);
        echo view('admin.voucher.view_filter_voucher', compact('all_voucher', 'product_name', 'product_id', 'string_title', 'type_filter', 'level_filter'));
    }

    public function filter_voucher_follow_date_many(Request $request)
    {
        $product_id = $request->productId;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $date_filter_start = date('Y-m-d', strtotime($date_start));
        $date_filter_end = date('Y-m-d', strtotime($date_end));

        $type_filter = 'date_many';
        $level_filter = '';
        $start_date = $date_filter_start;
        $end_date = $date_filter_end;

        $string_title = 'Voucher ???????c T???o " T??? Ng??y ' . date('d/m/Y', strtotime($date_start)) . '
                        ?????n Ng??y ' . date('d/m/Y', strtotime($date_filter_end)) . ' "';
        $all_voucher_db = Voucher::where('product_id', $product_id)->get();
        $product = Product::where('product_id', $product_id)->first();
        $product_name = $product->product_name;

        $arrayVoucher = [];
        foreach ($all_voucher_db as $voucher) {
            $created_at = date('Y-m-d', strtotime($voucher->created_at));
            if ($date_filter_start <= $created_at && $created_at <= $date_filter_end) {
                $arrayVoucher[] = $voucher;
            }
        }
        $all_voucher = array_reverse($arrayVoucher);
        echo view('admin.voucher.view_filter_voucher', compact('all_voucher', 'product_name', 'product_id', 'string_title', 'type_filter', 'level_filter', 'start_date', 'end_date'));
    }

    public function print_pdf_voucher(Request $request)
    {
        $product_id = $request->product_id;
        $all_voucher_db = Voucher::where('product_id', $product_id)->get();
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;


        switch ($type_filter) {
            case "apply":
                $date_now = Carbon::now('Asia/Ho_Chi_Minh');
                $all_voucher = Voucher::where('product_id', $product_id)
                    ->where('start_date', '<=', $date_now)
                    ->where('end_date', '>=', $date_now)
                    ->where('voucher_quantity', '>', 0)
                    ->orderBy('voucher_id', 'desc')
                    ->get();
                $product = Product::where('product_id', $product_id)->first();
                $product_name = $product->product_name;
                $string_title = 'Danh S??ch Voucher ??ang ??p D???ng - "' . $product_name . '"';
                $pdf = PDF::loadView(
                    'admin.voucher.view_print_pdf_voucher',
                    compact('all_voucher', 'string_title')
                );
                return $pdf->download('danhsachvoucherdangapdung.pdf');
                break;
            case "unapply":
                $date_now = Carbon::now('Asia/Ho_Chi_Minh');
                $all_voucher = Voucher::where('product_id', $product_id)
                    ->where('end_date', '<', $date_now)
                    ->orWhere('voucher_quantity', '=', 0)
                    ->orderBy('voucher_id', 'desc')
                    ->get();
                $product = Product::where('product_id', $product_id)->first();
                $product_name = $product->product_name;
                $string_title = 'Danh S??ch Voucher Ng??ng ??p D???ng - "' . $product_name . '"';
                $pdf = PDF::loadView(
                    'admin.voucher.view_print_pdf_voucher',
                    compact('all_voucher', 'string_title')
                );
                return $pdf->download('danhsachvoucherdangapdung.pdf');

                break;
            case "date":
                $date_filter = date('Y-m-d', strtotime($level_filter));

                $string_title = 'Danh S??ch Voucher Theo Ng??y "' . date('d/m/Y', strtotime($date_filter)) . '"';
                $product = Product::where('product_id', $product_id)->first();
                $product_name = $product->product_name;

                $arrayVoucher = [];
                foreach ($all_voucher_db as $voucher) {
                    $created_at = date('Y-m-d', strtotime($voucher->created_at));
                    if ($created_at == $date_filter) {
                        $arrayVoucher[] = $voucher;
                    }
                }
                $all_voucher = array_reverse($arrayVoucher);
                $pdf = PDF::loadView(
                    'admin.voucher.view_print_pdf_voucher',
                    compact('all_voucher', 'string_title')
                );
                return $pdf->download('danhsachvouchertheongay.pdf');
                break;
            case "date_many":
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $string_title = 'Danh S??ch Voucher "T??? Ng??y ' . date('d/m/Y', strtotime($start_date)) . '
                        ?????n Ng??y ' . date('d/m/Y', strtotime($end_date)) . '"';
                $product = Product::where('product_id', $product_id)->first();
                $product_name = $product->product_name;

                $arrayVoucher = [];
                foreach ($all_voucher_db as $voucher) {
                    $created_at = date('Y-m-d', strtotime($voucher->created_at));
                    if ($start_date <= $created_at && $created_at <= $end_date) {
                        $arrayVoucher[] = $voucher;
                    }
                }
                $all_voucher = array_reverse($arrayVoucher);
                $pdf = PDF::loadView(
                    'admin.voucher.view_print_pdf_voucher',
                    compact('all_voucher', 'string_title')
                );
                return $pdf->download('danhsachvouchertheongaytuychon.pdf');
                break;
            default:
                $all_voucher = Voucher::all();
                $string_title = 'Danh S??ch Voucher';
                $pdf = PDF::loadView(
                    'admin.voucher.view_print_pdf_voucher',
                    compact('all_voucher', 'string_title')
                );
                return $pdf->download('danhsachvouchertheongaytuychon.pdf');
        }
    }
}
