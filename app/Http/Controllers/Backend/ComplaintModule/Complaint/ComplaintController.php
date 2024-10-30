<?php

namespace App\Http\Controllers\Backend\ComplaintModule\Complaint;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\ComplaintModule\Complaint\CreateComplaintRequest;
use App\Http\Requests\Backend\Modules\ComplaintModule\Complaint\EditComplaintRequest;
use App\Services\Backend\Modules\ComplaintModule\Complaint\ComplaintService;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{

    protected ComplaintService $complaint_service;

    public function __construct(ComplaintService $complaint_service) {
        $this->complaint_service = $complaint_service;
    }

    public function index(){
        return $this->complaint_service->index();
    }
    public function data(Request $request){
        return $this->complaint_service->data($request->all());
    }
    public function add_modal(){
        return $this->complaint_service->add_modal();
    }
    public function add(CreateComplaintRequest $request){
        return $this->complaint_service->add($request);
    }
    public function edit_modal($id){
        return $this->complaint_service->edit_modal($id);
    }
    public function edit(EditComplaintRequest $request, $id){
        return $this->complaint_service->edit($request, $id);
    }
    public function details($id){
        return $this->complaint_service->details($id);
    }
}
