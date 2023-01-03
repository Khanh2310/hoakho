<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    protected $table = 'product';
    public $timestamps = false;
    protected $primaryKey = 'product_id';
    protected $fillable = [
    	'product_name', 'product_sort_desc', 'product_desc','product_image','unit_id','category_id'
    ];
    use Notifiable,
        SoftDeletes;
    protected $dates = ['deleted_at'];
}
