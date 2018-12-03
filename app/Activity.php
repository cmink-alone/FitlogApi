<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'datetime',
        'type_id',
        'hour',
        'minute',
        'distance',
        'description',
        'flag_push',
        'flag_delete',
    ];
}
