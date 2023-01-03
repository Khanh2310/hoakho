<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = [
    	'order_code', 'customer_id', 'total_price','payment_id','trans_id','status_pay','create_at'
    ];
}
