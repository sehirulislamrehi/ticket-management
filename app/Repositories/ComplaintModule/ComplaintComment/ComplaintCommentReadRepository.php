<?php

namespace App\Repositories\ComplaintModule\ComplaintComment;

use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentReadInterface;
use Illuminate\Support\Facades\Auth;

class ComplaintCommentReadRepository implements ComplaintCommentReadInterface
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth('web')->check() ? auth('web')->user() : Auth::guard("sanctum")->user();
    }

    

}
