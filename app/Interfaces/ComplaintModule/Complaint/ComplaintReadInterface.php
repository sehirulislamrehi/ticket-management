<?php

namespace App\Interfaces\ComplaintModule\Complaint;

interface ComplaintReadInterface{
    public function fetch_all_complaint($params);
    public function fetch_complaint_by_id($id);
    public function fetch_status_counting();
    public function fetch_priority_counting();
    public function fetch_category_counting();
    public function fetch_over_time_report();
}

?>