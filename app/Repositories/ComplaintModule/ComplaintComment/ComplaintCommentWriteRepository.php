<?php

namespace App\Repositories\ComplaintModule\ComplaintComment;

use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentWriteInterface;
use App\Models\ComplaintModule\ComplaintComment;
use Illuminate\Support\Facades\Auth;

class ComplaintCommentWriteRepository implements ComplaintCommentWriteInterface
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth('web')->check() ? auth('web')->user() : Auth::guard("sanctum")->user();
    }

    public function create($request, $complaint)
    {
        $auth = $this->auth;

        $complaint_comment = new ComplaintComment();
        $complaint_comment->complaint_id = $complaint->id;
        $complaint_comment->user_id = $auth->id;
        $complaint_comment->comment = $request->comment;
        $complaint_comment->save();

        return $complaint_comment;
    }

    public function update($request, $complaint_comment)
    {
        $complaint_comment->comment = $request->comment;
        $complaint_comment->save();
        return $complaint_comment;
    }

    public function delete_comment_by_id($id){
        return ComplaintComment::where("id", $id)->delete();
    }

}
