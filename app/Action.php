<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //
    protected $table = 'action';
    protected $primaryKey = 'action_id';
    protected $fillable = ['cate_id', 'admin_id', 'action_message','action_time'];
    public $timestamps = false;
}