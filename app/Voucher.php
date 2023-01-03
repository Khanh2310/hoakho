<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $table = 'voucher';
    protected $primaryKey = 'voucher_id';
    protected $fillable = ['voucher_code', 'voucher_name', 'voucher_quantity', 'voucher_amount', 'product_id', 'start_date', 'end_date', 'status'];
    public $timestamps = false;
}
