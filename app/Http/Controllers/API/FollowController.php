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
    public function getFollowers() 
    { 
        $followers = Auth::user()->followers(); 
        return response()->json($followers, $this-> successStatus); 
    } 

    public function follow(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'follower_id' => 'required', 
            'following_id' => 'required', 
        ]);
        $follow = Follow::create($request); 
        return response()->json($follow, $this-> successStatus); 
    } 

    
    public function unfollow(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'follower_id' => 'required', 
            'following_id' => 'required', 
        ]);
        $follow = Follow::create($request); 
        return response()->json($follow, $this-> successStatus); 
    } 
}