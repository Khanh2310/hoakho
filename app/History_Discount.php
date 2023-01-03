<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History_Discount extends Model
{
    protected $table = 'history_discount';
    protected $primaryKey = 'his_id';
    public $timestamps = false;
}
