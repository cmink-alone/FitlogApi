<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller 
{

public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $response['status'] = 200;
            $response['message'] = $user->createToken('MyApp')-> accessToken; 
            $response['user'] = $user;
            return response()->json($response, $this-> successStatus); 
        } 
        else{ 
            $response['status'] = 401;
            $response['message'] =  'Unauthorised';
            return response()->json($response, 401); 
        } 
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'gender' => 'required', 
            'birthday' => 'required', 
            'username' => 'required', 
            'password' => 'required', 
        ]);
        if ($validator->fails()) { 
            $response['status'] = 401;
            $response['message'] = "Failed to register";
            return response()->json($response, 401);            
        }

        $input = $request->all(); 

        $count = User::where(['username' => $input['username']])->count();
        if($count) {
            $response['status'] = 401;
            $response['message'] = "Username already exist";
            return response()->json($response, 401);      
        }

        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 

        $response['status'] = 200;
        $response['user'] = $user;
        $response['message'] = $user->createToken('MyApp')-> accessToken; 
        return response()->json($response, $this-> successStatus); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    
    /** 
     * User all api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAll() 
    { 
        $users = User::all();
        return response()->json($users, $this-> successStatus); 
    } 
}