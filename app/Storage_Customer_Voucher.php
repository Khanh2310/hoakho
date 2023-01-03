<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage_Customer_Voucher extends Model
{
    protected $table = 'storage_customer_voucher';
    protected $primaryKey = 'storage_voucher_id';
    protected $fillable = ['customer_id', 'voucher_id', 'status'];
    public $timestamps = false;
}
