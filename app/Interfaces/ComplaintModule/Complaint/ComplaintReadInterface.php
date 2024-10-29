<?php

namespace App\Interfaces\ComplaintModule\Complaint;

interface ComplaintReadInterface{
    public function fetch_all_complaint($params);
    public function fetch_complaint_by_id($id);
}

?>