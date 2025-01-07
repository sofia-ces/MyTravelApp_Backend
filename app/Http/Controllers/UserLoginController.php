<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\Auth\LoginServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginServiceInterface $loginService)
    {
        $this->loginService = $loginService;
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
            return response()->json(['code' => 200, 'success'=> 'Login successful!', 'data' => $request->all()]);
         
        }else{
            return response()->json(['code' => 422, 'success'=> 'Invalid Email/Password', 'data' => $request->all()]);
        }
    }
}