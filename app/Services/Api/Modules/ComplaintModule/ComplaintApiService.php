<?php

namespace App\Services\Api\Modules\ComplaintModule;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Interfaces\ComplaintModule\Complaint\ComplaintWriteInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Services\Pusher\PusherService;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class ComplaintApiService
{

     use ApiResponseTrait;
     private $auth;
     protected ComplaintWriteInterface $complaint_write_repository;
     protected ComplaintReadInterface $complaint_read_repository;
     protected PusherService $pusher_service;
     protected NotificationWriteInterface $notification_write_repository;

     public function __construct(ComplaintWriteInterface $complaint_write_interface, ComplaintReadInterface $complaint_read_interface,PusherService $pusher_service, NotificationWriteInterface $notification_write_interface)
     {
          $this->auth = Auth::guard("sanctum")->user();
          $this->complaint_write_repository = $complaint_write_interface;
          $this->complaint_read_repository = $complaint_read_interface;
          $this->pusher_service = $pusher_service;
          $this->notification_write_repository = $notification_write_interface;
     }

     public function create($request)
     {
          try {
               $complaint = $this->complaint_write_repository->add($request);
               return $this->success($complaint, "Complaint created");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function list()
     {
          try {
               $params = [
                    "user_id" => $this->auth->id,
               ];
               $query = $this->complaint_read_repository->fetch_all_complaint($params);
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
               $auth = $this->auth;
               $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
               if(!$complaint){
                    return $this->error([],"No complaint found");
               }
               if(!$auth->is_super_admin){
                    return $this->error([],"Only superadmin can able to change status");
               }
               
               if($this->complaint_write_repository->update_complaint_status_for_api($request->status, $complaint)){
                    //save notification for update complaint successfully
                    $params = [
                         "from_user_id" => $auth->id,
                         "to_user_id" => $complaint->created_by,
                         "message" => "'{$complaint->title}' complaint is updated.",
                         "is_viewed" => false,
                         "link" => null,
                         "created_at" => Carbon::now(),
                         "updated_at" => Carbon::now(),
                    ];
                    $this->notification_write_repository->create($params);

                    //trigger pusher for real time notification alert
                    $pusher_params = [
                         "to_user_id" => $complaint->created_by,
                         "message" => $params['message'],
                         "data" => [],
                         "event" => "notification-{$complaint->created_by}"
                    ];
                    $this->pusher_service->trigger($pusher_params);
               }

               return $this->success([],"Complaint status updated");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }
}
