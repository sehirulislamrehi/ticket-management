<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Api\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    protected LoginService $login_service;

    public function __construct(LoginService $login_service)
    {
        $this->login_service = $login_service;
    }
    
    public function login(LoginRequest $request){
        return $this->login_service->login($request);
    }

}
