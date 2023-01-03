<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    protected $fillable = ['cate_name', 'cate_image'];
    public $timestamps = false;
}
