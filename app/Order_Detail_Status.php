<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Detail_Status extends Model
{
    protected $table = 'order_detail_status';
    protected $primaryKey = 'detail_status_id';
    public $timestamps = false;
    protected $fillable = [
    	'order_id', 'status_id', 'time_status','status'
    ];
}
