<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';
    protected $primaryKey = 'discount_id';
    public $timestamps = false;
    protected $fillable = [
    	'start_date_1','end_date_1','discount_amount_1','condition_discount_1','start_date_2','end_date_2','discount_amount_2','condition_discount_2'
    ];
}
