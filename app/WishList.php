<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wish_list';
    public $timestamps = false;
    protected $primaryKey = 'wish_list_id';
    protected $fillable = ['product_id', 'customer_id', 'created_at'];
}
