<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Admin;
class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'roles_id';
    public $timestamps = false;
    protected $fillable = [
    	'name'
    ];

    public function admin(){
        return $this->belongsToMany('App\Admin', 'admin_roles');
    }
}
