<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;
    protected $table = 'product_price';
    public $timestamps = false;
    protected $primaryKey = 'price_id';
    protected $fillable = [
    	'product_id', 'price', 'status', 'updated_at',
    ];
}
