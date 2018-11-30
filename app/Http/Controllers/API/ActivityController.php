<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Activity; 
use App\Follow; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class ActivityController extends Controller 
{

public $successStatus = 200;
    /** 
     * types api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function allFollowing() 
    { 
        $user = Auth::user(); 
        $user_ids = $user->followings->pluck('which_followed_id')->toArray();
        $user_ids[]=$user->id;
        $activities = Activity::whereIn("user_id",$user_ids)->get(); 
        return response()->json(['success' => $activities], $this-> successStatus); 
    } 

    public function add(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'user_id' => 'required', 
            'datetime' => 'required', 
            'type_id' => 'required', 
            'hour' => 'required', 
            'minute' => 'required', 
            'distance' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $activity = Activity::create($input); 
        return response()->json(['success'=>$activity], $this-> successStatus); 
    }

    
    public function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'id' => 'required', 
            'user_id' => 'required', 
            'datetime' => 'required', 
            'type_id' => 'required', 
            'hour' => 'required', 
            'minute' => 'required', 
            'distance' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $activity = Activity::find($input['id'])->update($input); 
        return response()->json(['success'=>$activity], $this-> successStatus); 
    }

    
    public function delete(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'id' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $activity = Activity::find($input['id'])->delete(); 
        return response()->json(['success'=>$activity], $this-> successStatus); 
    }
}