<?php

namespace App\Http\Controllers\Backend\ComplaintModule\ComplaintComment;

use App\Http\Controllers\Controller;
use App\Services\Backend\Modules\ComplaintModule\ComplaintComment\ComplaintCommentService;
use Illuminate\Http\Request;

class ComplaintCommentController extends Controller
{
    
    protected ComplaintCommentService $complaint_comment_service;

    public function __construct(ComplaintCommentService $complaint_comment_service)
    {
        $this->complaint_comment_service = $complaint_comment_service;
    }

    public function add(Request $request){
        return $this->complaint_comment_service->add($request);
    }

}
