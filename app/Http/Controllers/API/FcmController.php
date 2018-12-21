<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Fcm_token; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class FcmController extends Controller 
{

public $successStatus = 200;
    /** 
     * types api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function insert($token) 
    { 
        $count = Fcm_token::where('user_id', Auth::user()->id)
                ->where('token', $token)->count();
        if($count == 0){
            $input['user_id'] =  Auth::user()->id;
            $input['token'] = $token;
            $tokens = Fcm_token::create($input); 
            $msg = $tokens->token;
        } else {
            $msg = 0;
        }
        return response()->json(['success' => $msg], $this-> successStatus); 
    } 
    
    public function delete($token) 
    { 
        $token = Fcm_token::where('user_id', Auth::user()->id)
                ->where('token', $token)->delete();
        return response()->json(['success' => $token], $this-> successStatus); 
    } 
}