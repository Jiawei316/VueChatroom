<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'Friends';
    protected $fillable = ['self_index','friend_index','isAccept'];
}
