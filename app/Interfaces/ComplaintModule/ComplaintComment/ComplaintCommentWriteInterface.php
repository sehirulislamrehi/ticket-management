<?php

namespace App\Interfaces\ComplaintModule\ComplaintComment;

interface ComplaintCommentWriteInterface{
     public function create($request, $complaint);
     public function update($request, $complaint_comment);
     public function delete_comment_by_id($id);
}

?>