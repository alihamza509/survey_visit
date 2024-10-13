<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;
use Dotenv\Validator;
use Exception;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }
    
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Invalid login details', 401);
            }
    
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return $this->success([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $e) {
            return $this->error('An error occurred during login', 500);
        }
    }
    
}
