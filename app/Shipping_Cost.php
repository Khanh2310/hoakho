<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping_Cost extends Model
{
    //
    protected $table = 'shipping_cost';
    protected $primaryKey = 'id';
    protected $fillable = ['start_position', 'end_position', 'cost'];
    public $timestamps = false;
}
