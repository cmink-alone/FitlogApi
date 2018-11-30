<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'which_following_id', 
        'which_followed_id', 
        'datetime',
    ];
}
