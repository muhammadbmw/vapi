<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Profile;  
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
	/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|string',
            'password' => 'required|min:8|string',
            'gv_id' => 'required|integer|unique:users',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation Error.'
            ];
            return response()->json($response, 200);
           
        }
		
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully.'
        ];
		Profile::create([
			'user_id' => $user->id,
		]);
        return response()->json($response, 200);
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
		$validator = Validator::make($request->all(), [
        
            'email' => 'required|email',
            'password' => 'required',
    
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation Error.'
            ];
            return response()->json($response, 200);
        }
		
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Token')->accessToken;
			$success['id'] = $user->id;
			$success['name'] = $user->name;
           $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User login successfully.'
        ];
        return response()->json($response, 200);
        } else {
				 $response = [
            'success' => false,
            'message' => 'login credential does not match.'
        ];
             return response()->json($response, 200);
        }
    }
	
	public function logout(Request $request)
    {
       $request->user()->token()->revoke();
		$response = [
            'success' => true,
            'message' => 'Successfully logged out'
        ];
        return response()->json($response, 200);
		
    }
	
    
}
