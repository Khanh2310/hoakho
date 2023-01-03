<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    public $timestamps = false;
}
