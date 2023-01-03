<?php

namespace App\Http\Controllers;

use App\Admin_Action_Shipping_Cost;
use App\Http\Controllers\Controller;
use App\Shipping_Cost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Session;

class ShippingCostController extends Controller
{
    //
    public function all_shipping_cost()
    {
        $all_shipping_cost = Shipping_Cost::paginate(10);
        return view('admin.shipping_cost.all_shipping_cost', compact('all_shipping_cost'));
    }

    public function add_shipping_cost()
    {
        $citys = DB::table('tinhthanhpho')->get();
        return view('admin.shipping_cost.add_shipping_cost', compact('citys'));
    }

    public function process_add_shipping_cost(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $start_position = $request->start_position;
        $end_position = $request->end_position;
        $cost = $request->cost;
        $this->validate(
            $request,
            [
                'start_position' => 'required',
                'end_position' => 'required',
            ],
            [
                'start_poistion.required' => 'Vui Lòng Điền Vị Trí Bắt Đầu',
                'end_position.required' => 'Vui Lòng Điền Vị Trí Kết Thúc',
            ]
        );
        $name_city_start = DB::table('tinhthanhpho')->where('matp', $start_position)->first();
        $name_start_position = $name_city_start->name_tp;

        $name_city_end = DB::table('tinhthanhpho')->where('matp', $end_position)->first();
        $name_end_position = $name_city_end->name_tp;

        $position_db = Shipping_Cost::where('start_position', $name_start_position)
            ->where('end_position', $name_end_position)
            ->first();
        if ($position_db) {
            $request->session()->flash('error_position', 'Vị Trí Bắt Đầu Và Kết Thúc Đã Tồn Tại');
            return redirect()->back();
        } else if ($cost < 1000) {
            $request->session()->flash('cost', 'Phí Vận Chuyển Không Được Nhỏ Hơn 1.000');
            return redirect()->back();
        } else {
            $shipping_cost = new Shipping_Cost();
            $shipping_cost->start_position = $name_start_position;
            $shipping_cost->end_position = $name_end_position;
            $shipping_cost->cost = $cost;
            $shipping_cost->save();

            $request->session()->flash('success_shipping_cost', 'Thêm Phí Vận Chuyển Thành Công');
            return redirect('admin/all_shipping_cost');
        }
    }

    public function delete_shipping_cost(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $shipping_cost_id = $request->shipping_cost_id;
        Shipping_Cost::destroy($shipping_cost_id);

        $request->session()->flash('success_shipping_cost', 'Xóa Phí Vận Chuyển Thành Công');
        return redirect('admin/all_shipping_cost');
    }

    public function update_shipping_cost(Request $request, $shipping_cost_id)
    {
        $shipping_cost = Shipping_Cost::find($shipping_cost_id);
        $citys = DB::table('tinhthanhpho')->get();
        return view('admin.shipping_cost.update_shipping_cost', compact('shipping_cost', 'citys'));
    }

    public function process_update_shipping_cost(Request $request, $shipping_cost_id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $start_position = $request->start_position;
        $end_position = $request->end_position;
        $cost = $request->cost;
        $this->validate(
            $request,
            [
                'start_position' => 'required',
                'end_position' => 'required',
            ],
            [
                'start_poistion.required' => 'Vui Lòng Điền Vị Trí Bắt Đầu',
                'end_position.required' => 'Vui Lòng Điền Vị Trí Kết Thúc',
            ]
        );
        $name_city_start = DB::table('tinhthanhpho')->where('matp', $start_position)->first();
        $name_start_position = $name_city_start->name_tp;

        $name_city_end = DB::table('tinhthanhpho')->where('matp', $end_position)->first();
        $name_end_position = $name_city_end->name_tp;

        $position_db = Shipping_Cost::where('start_position', $name_start_position)
            ->where('end_position', $name_end_position)
            ->where('id', '<>', $shipping_cost_id)
            ->first();
        if ($position_db) {
            $request->session()->flash('error_position', 'Vị Trí Bắt Đầu Và Kết Thúc Đã Tồn Tại');
            return redirect()->back();
        } else if ($cost < 1000) {
            $request->session()->flash('cost', 'Phí Vận Chuyển Không Được Nhỏ Hơn 1.000');
            return redirect()->back();
        } else {
            $shipping_cost = Shipping_Cost::find($shipping_cost_id);
            $shipping_cost->start_position = $name_start_position;
            $shipping_cost->end_position = $name_end_position;
            $shipping_cost->cost = $cost;
            $shipping_cost->save();

            $request->session()->flash('success_shipping_cost', 'Sửa Phí Vận Chuyển Thành Công');
            return redirect('admin/all_shipping_cost');
        }
    }

    public function find_shipping_cost(Request $request)
    {
        $value_find = $request->value_find;
        $all_shipping_cost = Shipping_Cost::where('start_position', 'LIKE', '%' . $value_find . '%')
            ->orWhere('end_position', 'LIKE', '%' . $value_find . '%')
            ->orWhere('cost', 'LIKE', '%' . $value_find . '%')
            ->get();
        echo view('admin.shipping_cost.result_find_shipping_cost', compact('all_shipping_cost'));
    }
}
