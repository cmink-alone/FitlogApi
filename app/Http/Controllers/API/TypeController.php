<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Type; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class TypeController extends Controller 
{

public $successStatus = 200;
    /** 
     * types api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function all() 
    { 
        $types = Type::all(); 
        return response()->json(['success' => $types], $this-> successStatus); 
    } 
}