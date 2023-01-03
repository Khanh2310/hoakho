<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['product_id', 'quantity', 'customer_id', 'created_at'];
    public $timestamps = false;
}
