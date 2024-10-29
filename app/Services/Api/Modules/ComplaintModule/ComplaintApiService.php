<?php

namespace App\Services\Api\Modules\ComplaintModule;

use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ComplaintApiService
{

     use ApiResponseTrait;
     private $auth;

     public function __construct()
     {
          $this->auth = Auth::user();
     }

     public function create($request)
     {
          
     }
}
