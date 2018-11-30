<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Follow; 
use Illuminate\Support\Facades\Auth; 

class FollowController extends Controller 
{

public $successStatus = 200;
    /** 
     * follow api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAll() 
    { 
        $types = Follow::all(); 
        return response()->json($types, $this-> successStatus); 
    } 
}