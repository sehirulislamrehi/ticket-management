<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomScantumAuth
{


    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        return $next($request);
    }
}
