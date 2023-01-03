<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AddressController extends Controller
{
    public function load_district(Request $request){
        $city = $request->city;
        $district = DB::table('quanhuyen')->where('matp',$city)->get();
        echo '<option value="">Quận/Huyện</option>';
        foreach ($district as $ds){
            echo '<option value="'. $ds->maqh .'">'.$ds->name_qh.'</option>';
        }
    }
    public function load_ward(Request $request){
        $district = $request->district;
        $ward = DB::table('xaphuongthitran')->where('maqh',$district)->get();
        echo '<option value="">Phường/Xã</option>';
        foreach ($ward as $w){
            echo '<option value="'. $w->xaid .'">'.$w->name_xa.'</option>';
        }
    }
}
