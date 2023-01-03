<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage_Voucher extends Model
{
    //
    protected $table = 'storage_voucher_customer';
    protected $fillable = ['storage_voucher_id', 'customer_id', 'voucher_id'];
    public $timestamps = false;
}
