<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    protected $table = 'order_item';
    protected $primaryKey = 'order_item_id';
    public $timestamps = false;
    protected $fillable = [
    	'product_id', 'order_id', 'quantity_product','price_product',
    ];
}
