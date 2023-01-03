<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage_Product extends Model
{
    //
    use SoftDeletes;
    protected $table = 'storage_product';
    protected $primaryKey = 'storage_product_id';
    protected $fillable = ['storage_id', 'product_id', 'total_quantity_product'];
    public $timestamps = false;
}
