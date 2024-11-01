<?php

namespace App\Interfaces\ComplaintModule\ComplaintComment;

interface ComplaintCommentReadInterface{
     public function fetch_comments_by_complaint($complaint);
     public function fetch_comments_by_id($id);
}

?>