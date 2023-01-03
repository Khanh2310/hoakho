<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $fillable = [
    	'username','email','password'
    ];
}
