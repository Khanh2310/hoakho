<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_Transport extends Model
{
    //
    protected $table = 'customer_transport';
    protected $primaryKey = 'trans_id';
    public $timestamps = false;
    protected $fillable = [
    	'customer_id', 'trans_fullname', 'trans_phone', 'trans_address', 'trans_status',
    ];
}
