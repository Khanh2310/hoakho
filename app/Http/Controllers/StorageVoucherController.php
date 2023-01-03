<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use App\Storage_Customer_Voucher;
use App\Voucher;
use Illuminate\Http\Request;

class StorageVoucherController extends Controller
{
    //
    public function process_save_voucher(Request $request)
    {
        $voucher_id = $request->voucher_id;
        if (!Session::get('customer_id')) {
            echo 1;
        } else {
            $voucher = Voucher::where('voucher_id', $voucher_id)->first();
            $quantity_old = $voucher->voucher_quantity;
            $voucher->voucher_quantity = $quantity_old - 1;
            $result_save_voucher = $voucher->save();

            if ($result_save_voucher) {
                $storage_customer_voucher = new Storage_Customer_Voucher();
                $storage_customer_voucher->customer_id = Session::get('customer_id');
                $storage_customer_voucher->voucher_id = $voucher_id;
                $storage_customer_voucher->save();
                echo 2;
            }
        }
    }
}
