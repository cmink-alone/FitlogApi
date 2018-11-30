<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 
        'gender', 
        'birthday',
        'weight',
        'height',
        'username',
        'password',
    ];

    protected $hidden = [
        'password', 'token',
    ];

    public function followings(){
        return $this->hasMany('App\Follow','follower_id');
    }
    
    public function followers(){
        return $this->hasMany('App\Follow','following_id');
    }
}
