<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageProduct extends Model
{
    use SoftDeletes;
    protected $table = 'product_image';
    protected $primaryKey = 'image_id';
    protected $fillable = ['product_id', 'image', 'create_at','deleted_at'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];



}
