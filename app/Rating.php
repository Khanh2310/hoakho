<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'rating_id';
    protected $fillable = [
    	'product_id', 'customer_id', 'rating_level', 'create_at',
    ];
    public $timestamps = false;
}
