<?php

namespace App\Interfaces\ComplaintModule\Complaint;

interface ComplaintWriteInterface{
    public function add($request);
    public function edit($request, $data);
    public function update_complaint_status_for_api($status,$complaint);
}

?>