<?php

namespace App\Services\Api\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class LoginService
{

     use ApiResponseTrait;

     public function login($request)
     {
          $credentials = $request->only('email', 'password');

          if (Auth::attempt($credentials)) {
               $user = Auth::user();
               $token = $user->createToken('API Token')->plainTextToken;

               return $this->success([
                    "user" => $user,
                    "api_token" => $token
               ],"Login success");
          }
     }
}
