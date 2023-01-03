<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Storage_Product extends Model
{
    //
    protected $table = 'import_storage_product';
    protected $fillable = ['admin_id','quantity_import', 'quantity_current', 'quantity_total','storage_product_id'];
    public $timestamps = false;
}
