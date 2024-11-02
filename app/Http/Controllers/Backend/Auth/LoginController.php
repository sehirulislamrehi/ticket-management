<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\Auth\LoginRequest;
use App\Services\Backend\Auth\AuthenticationService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\Artisan;

class LoginController extends Controller
{
    
    use ApiResponseTrait;

    protected AuthenticationService $authentication_service;

    public function __construct(AuthenticationService $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function index(){
        if (auth('web')->check()) {
            Artisan::call("migrate");
            return redirect()->route("dashboard");
        } else {
            return view("backend.auth.login");
        }
    }

    public function do_login(LoginRequest $request){
        try{
            return $this->authentication_service->do_login($request);
        }
        catch( Exception $e ){
            return $this->error("", $e->getMessage());
        }

    }
}
