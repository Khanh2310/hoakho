<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    //
    use SoftDeletes;
    protected $table = 'storage';
    protected $primaryKey = 'storage_id';
    protected $fillable = ['storage_name'];
    public $timestamps = false;
}
