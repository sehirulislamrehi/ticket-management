<?php

namespace App\Repositories\ComplaintModule\ComplaintComment;

use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentWriteInterface;
use Illuminate\Support\Facades\Auth;

class ComplaintCommentWriteRepository implements ComplaintCommentWriteInterface
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth('web')->check() ? auth('web')->user() : Auth::guard("sanctum")->user();
    }

    public function create($request)
    {
          
    }

}
