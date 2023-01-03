<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_Info extends Model
{
    //
    protected $table = 'customer_info';
    protected $primaryKey = 'cus_info_id';
    public $timestamps = false;
    protected $fillable = [
    	'customer_id', 'customer_fullname', 'customer_phone', 'customer_avt', 'customer_gender', 'customer_birthday'
    ];
}
