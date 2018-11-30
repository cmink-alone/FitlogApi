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
            'weight' => 'required', 
            'height' => 'required', 
            'username' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
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
        return response()->json(['success' => $users], $this-> successStatus); 
    } 
}