<?php

namespace App\Http\Controllers;

use App\Admin_Action_Slider;
use App\Http\Controllers\Controller;
use App\Slider;
use Session;
use Carbon\Carbon;
use Dotenv\Regex\Result;
use Illuminate\Http\Request;
use DB;

class SliderController extends Controller
{
    //
    public function all_slider()
    {
        $all_slider = Slider::orderBy('slider_id', 'desc')->paginate(10);
        return view('admin.slider.all_slider', compact('all_slider'));
    }
    public static function show_slider()
    {
        $all_slider = Slider::where('slider_status', 1)->get();
        return $all_slider;
    }
    public function add_slider()
    {
        return view('admin.slider.add_slider');
    }
    public function process_add_slider(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->validate_slider($request);

        $get_image = $request->file('slider_image');
        if (isset($get_image)) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $slider_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload', $slider_image);
        }

        $all_slider_status = Slider::where('slider_status', 1)->get();

        $new_slider = new Slider();
        if (count($all_slider_status) >= 10) {
            $new_slider->slider_image = $slider_image;
            $new_slider->slider_status = 0;
            $new_slider->save();

            $request->session()->flash('slider_status_unactive', 'Thêm slider thành công! Trạng thái được chuyển về TẮT vì đã đủ 10 slider đang chạy');
            return redirect('admin/all_slider');
        } else {
            $new_slider->slider_image = $slider_image;
            $new_slider->slider_status = 1;
            $new_slider->save();

            $request->session()->flash('slider_status_active', 'Thêm slider thành công!');
            return redirect('admin/all_slider');
        }
    }
    public function process_delete_slider(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $slider_id = $request->slider_id;
        Slider::destroy($slider_id);

        $request->session()->flash('delete_slider', 'Xóa slider thành công!');
        return redirect('admin/all_slider');
    }
    public function active_slider(Request $request, $slider_id)
    {
        $all_slider_status = Slider::where('slider_status', 1)->get();
        if (count($all_slider_status) >= 10) {
            $request->session()->flash('error_active_slider', 'Trạng thái không thể BẬT vì đã đủ 10 slider đang chạy');
            return redirect()->back();
        } else {
            $slider = Slider::where('slider_id', $slider_id)->first();
            $slider->slider_status = 1;
            $slider->save();
            $request->session()->flash('change_status_slider', 'Thay đổi trạng thái thành công!');
            return redirect()->back();
        }
    }
    public function unactive_slider(Request $request, $slider_id)
    {
        $slider = Slider::where('slider_id', $slider_id)->first();
        $slider->slider_status = 0;
        $slider->save();
        $request->session()->flash('change_status_slider', 'Thay đổi trạng thái thành công!');
        return redirect()->back();
    }
    public function validate_slider(Request $request)
    {
        $request->validate([
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,svg',
        ], [
            'slider_image.required' => 'Vui lòng chọn ảnh',
            'slider_image.image' => 'Vui lòng chọn file dưới dạng hình ảnh',
            'slider_image.mimes' => 'Vui lòng chọn file có đuôi jpeg,png,jpg,svg',
        ]);
    }
}
