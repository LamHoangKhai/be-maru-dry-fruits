<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'profile']]);
    }

    public function register(RegisterRequest $request) {
                // Use request default of laravel
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|confirmed|min:6'
        // ], [
        //     'email.required' => 'Please enter your email',
        //     'email.email' => 'It\'s not an email',
        //     'email.unique' => 'This email was exist',
        //     'password.required' => 'Please enter your password',
        //     'password.confirmed' => 'Password confirmation is not correct',
        //     'password.min' => 'Password must be at least 6 charactors',
        // ]);

        // if($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()],400);
        // }

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json([
            'message' => 'User successfully registered',
        ],201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->all();
                // Use the default request of laravel
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|min:6'
        // ], [
        //     'email.required' => 'Please enter your email',
        //     'email.email' => 'It\'s not an email',
        //     'password.required' => 'Please enter your password',
        //     'password.min' => 'Password must be at least 6 charactors',
        // ]);

        // if($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 422);
        // }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        if($user->level != 1) {
            auth()->logout();
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->respondWithToken($token);
        
    }

    public function profile() {
        if(auth()->user()) {
            return response()->json([
                auth()->user()
            ]);
        }
        else {
            return response()->json([
                'message' => 'You need to login to get profile'
            ],400);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}