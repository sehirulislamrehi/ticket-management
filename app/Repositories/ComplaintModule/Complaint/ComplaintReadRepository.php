<?php

namespace App\Repositories\ComplaintModule\Complaint;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Models\ComplaintModule\Complaint;

class ComplaintReadRepository implements ComplaintReadInterface
{

    public function fetch_all_complaint($params){
        return Complaint::query()->with("created_user");
    }

    public function fetch_complaint_by_id($id){
        return Complaint::query()->where("id", $id)->with("created_user")->first();
    }

}
