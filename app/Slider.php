<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $table = 'slider';
    protected $primaryKey = 'slider_id';
    protected $fillable = ['slider_image', 'slider_status'];
    public $timestamps = false;
}
