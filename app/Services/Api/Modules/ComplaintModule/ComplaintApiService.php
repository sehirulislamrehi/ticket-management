<?php

namespace App\Services\Api\Modules\ComplaintModule;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Interfaces\ComplaintModule\Complaint\ComplaintWriteInterface;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

class ComplaintApiService
{

     use ApiResponseTrait;
     private $auth;
     protected ComplaintWriteInterface $complaint_write_repository;
     protected ComplaintReadInterface $complaint_read_repository;

     public function __construct(ComplaintWriteInterface $complaint_write_interface, ComplaintReadInterface $complaint_read_interface)
     {
          $this->auth = Auth::guard("sanctum")->user();
          $this->complaint_write_repository = $complaint_write_interface;
          $this->complaint_read_repository = $complaint_read_interface;
     }

     public function create($request)
     {
          try {
               $this->complaint_write_repository->add($request);
               return $this->success(null, "Complaint created");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function list($request)
     {
          try {
               $query = $this->complaint_read_repository->fetch_all_complaint($request);
               return $this->success($query->get(),"Complaints");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function details($id)
     {
          try {
               $data = $this->complaint_read_repository->fetch_complaint_by_id($id);
               return $this->success($data,"Complaint details");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function update_status($request, $id){
          try {
               $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
               if(!$complaint){
                    return $this->error([],"No complaint found");
               }
               if(!$this->auth->is_super_admin){
                    return $this->error([],"Only superadmin can able to change status");
               }
               $this->complaint_write_repository->update_complaint_status_for_api($request->status, $complaint);
               return $this->success([],"Complaint status updated");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }
}
