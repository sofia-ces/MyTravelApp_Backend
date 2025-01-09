<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Interfaces\Auth\LoginServiceInterface;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    protected $loginService;
    protected $service;

    public function __construct(LoginServiceInterface $loginService,UserService $service)
    {
        $this->loginService = $loginService;
        $this->service = $service;
    }

    public function login(Request $request)
    {
   
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
    
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if ($this->loginService->authenticate($request->all())) {
            $token = $this->service->token($request->only('email', 'password')); // Pass only email and password
            return response()->json(['code' => 200,
             'success'=> 'Login successful!', 
             'data' => $request->all(),
             'token' => $token]);
         
        }else{
            return response()->json(['code' => 422, 'success'=> 'Invalid Email/Password', 'data' => $request->all()]);
        }
    }
}