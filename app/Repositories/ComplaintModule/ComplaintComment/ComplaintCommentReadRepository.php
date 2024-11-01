<?php

namespace App\Repositories\ComplaintModule\ComplaintComment;

use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentReadInterface;
use App\Models\ComplaintModule\ComplaintComment;
use Illuminate\Support\Facades\Auth;

class ComplaintCommentReadRepository implements ComplaintCommentReadInterface
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth('web')->check() ? auth('web')->user() : Auth::guard("sanctum")->user();
    }

    public function fetch_comments_by_complaint($complaint){
        return ComplaintComment::query()->with("user")->where("complaint_id", $complaint->id);
    }

    public function fetch_comments_by_id($id){
        return ComplaintComment::query()->orderBy("id","desc")->with("user")->where("id", $id);
    }

}   
