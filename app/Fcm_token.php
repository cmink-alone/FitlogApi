<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fcm_token extends Model
{
    protected $fillable = [
        'user_id', 
        'token', 
    ];

        
    public function user(){
        return $this->hasOne('App\User');
    }
}
