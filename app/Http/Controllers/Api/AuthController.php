<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
    
        $user =  User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response(compact('user', 'token'));
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = auth()->user();

        return response(compact('user', 'token'));
    }

    
    public function logout()
    {
       auth()->logout(true);

       return response('', 204);
    }


    
    public function refresh()
    {
        try {
            $token = JWTAuth::getToken();

            $refreshedToken = JWTAuth::refresh($token);

            $user = auth()->user();

            return response()->json(['user' => $user, 'token' => $refreshedToken]);

        } catch (JWTException $e) {
            
            return response()->json(['error' => 'Could not refresh token'], 500);
        }

        
    }


}