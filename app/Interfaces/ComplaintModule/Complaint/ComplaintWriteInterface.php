<?php

namespace App\Interfaces\ComplaintModule\Complaint;

interface ComplaintWriteInterface{
    public function add($request);
    public function edit($request, $data);
}

?>