<?php

namespace App\Http\Controllers\API;

use DB;
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
        $followers = DB::table('users')
                    ->join('follows','users.id','=','follows.follower_id')
                    ->select('users.id', 'users.name', 'users.gender', 'users.birthday', 'users.weight', 'users.height', 'users.username')
                    ->where('follows.following_id','=',Auth::user()->id)
                    ->get();
        return response()->json($followers, $this-> successStatus); 
    } 

    public function getFollowing() 
    { 
        $following = DB::table('users')
                    ->join('follows','users.id','=','follows.following_id')
                    ->select('users.id', 'users.name', 'users.gender', 'users.birthday', 'users.weight', 'users.height', 'users.username')
                    ->where('follows.follower_id','=',Auth::user()->id)
                    ->get();
        return response()->json($following, $this-> successStatus); 
    } 

    public function search($q) 
    { 
        $users = DB::table('users')
                    ->select('users.id', 'users.name', 'users.gender', 'users.birthday', 'users.weight', 'users.height', 'users.username',
                        DB::raw('EXISTS(SELECT id FROM follows WHERE following_id=users.id AND follower_id='.Auth::user()->id.') AS followed')
                    )
                    ->where('id','!=',Auth::user()->id)
                    ->where(function($query) use ($q){
                        $query->where('username','LIKE','%'.$q.'%')
                        ->orWhere('name','LIKE','%'.$q.'%');
                    })
                    ->get();
        return response()->json($users, $this-> successStatus); 
    } 

    public function follow(Request $id) 
    { 
        $data['follower_id'] = Auth::user()->id;
        $data['following_id'] = $id;
        $follow = Follow::create($request); 
        return response()->json($follow, $this-> successStatus); 
    } 

    public function unfollow($id) 
    { 
        $follow = Follow::where('follower_id', Auth::user()->id)
                        ->where('following_id', $id)->delete();
        return response()->json($follow, $this-> successStatus); 
    } 

    public function removeFollower($id) 
    { 
        $follow = Follow::where('follower_id', $id)
                        ->where('following_id', Auth::user()->id)->delete();
        return response()->json($follow, $this-> successStatus); 
    } 
}