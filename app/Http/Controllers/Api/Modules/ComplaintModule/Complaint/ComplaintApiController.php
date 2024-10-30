<?php

namespace App\Http\Controllers\Api\Modules\ComplaintModule\Complaint;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Modules\ComplaintModule\Complaint\ComplaintListRequest;
use App\Http\Requests\Api\Modules\ComplaintModule\Complaint\CreateComplaintRequest;
use App\Http\Requests\Api\Modules\ComplaintModule\Complaint\UpdateComplaintRequest;
use App\Services\Api\Modules\ComplaintModule\ComplaintApiService;
use Illuminate\Http\Request;

class ComplaintApiController extends Controller
{

    protected ComplaintApiService $complaint_api_service;

    public function __construct(ComplaintApiService $complaint_api_service)
    {
        $this->complaint_api_service = $complaint_api_service;
    }
    public function create(CreateComplaintRequest $request){
        return $this->complaint_api_service->create($request);
    }
    public function list(ComplaintListRequest $request){
        return $this->complaint_api_service->list($request);
    }
    public function details($id){
        return $this->complaint_api_service->details($id);
    }
    public function update_status(UpdateComplaintRequest $request, $id){
        return $this->complaint_api_service->update_status($request, $id);
    }
}
