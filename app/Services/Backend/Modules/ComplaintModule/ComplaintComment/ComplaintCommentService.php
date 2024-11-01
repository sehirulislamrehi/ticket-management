<?php

namespace App\Services\Backend\Modules\ComplaintModule\ComplaintComment;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentReadInterface;
use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentWriteInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Services\Pusher\PusherService;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Exception;

class ComplaintCommentService
{

     use ApiResponseTrait;

     protected ComplaintCommentReadInterface $complaint_comment_read_repository;
     protected ComplaintCommentWriteInterface $complaint_comment_write_repository;
     protected ComplaintReadInterface $complaint_read_repository;
     protected NotificationWriteInterface $notification_write_repository;
     protected PusherService $pusher_service;
     protected $auth;

     public function __construct(
          ComplaintCommentWriteInterface $complaint_comment_write_interface,
          ComplaintReadInterface $complaint_read_interface,
          ComplaintCommentReadInterface $complaint_comment_read_interface,
          NotificationWriteInterface $notification_write_interface,
          PusherService $pusher_service
     ) {
          $this->complaint_comment_write_repository = $complaint_comment_write_interface;
          $this->complaint_read_repository = $complaint_read_interface;
          $this->complaint_comment_read_repository = $complaint_comment_read_interface;
          $this->notification_write_repository = $notification_write_interface;
          $this->pusher_service = $pusher_service;
          $this->auth = auth('web')->user();
     }

     public function add($request, $id)
     {
          try {
               $auth = $this->auth;
               $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
               $response = $this->complaint_comment_write_repository->create($request, $complaint);
               $complaint_comment = $this->complaint_comment_read_repository->fetch_comments_by_id($response->id)->first();

               if ($auth->id != $complaint->created_by) {
                    //save notification for update complaint successfully
                    $params = [
                         "from_user_id" => $auth->id,
                         "to_user_id" => $complaint->created_by,
                         "message" => "{$auth->name} comment in your complaint name '{$complaint->title}'",
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
                         "data" => []
                    ];
                    $this->pusher_service->trigger($pusher_params);
               }

               return $this->success($complaint_comment, "New comment added");
          } catch (Exception $e) {
               return $this->error($e->getMessage());
          }
     }

     public function get($id)
     {
          try {
               $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
               $comments = $this->complaint_comment_read_repository->fetch_comments_by_complaint($complaint)->get();
               return $this->success($comments, "Comment list");
          } catch (Exception $e) {
               return $this->error($e->getMessage());
          }
     }

     public function edit($request, $id)
     {
          try {
               $complaint_comment = $this->complaint_comment_read_repository->fetch_comments_by_id($id)->first();
               $this->complaint_comment_write_repository->update($request, $complaint_comment);

               return $this->success(null, "Comment updated");
          } catch (Exception $e) {
               return $this->error($e->getMessage());
          }
     }

     public function delete($id)
     {
          try {
               $this->complaint_comment_write_repository->delete_comment_by_id($id);
               return $this->success(null, "Comment deleted");
          } catch (Exception $e) {
               return $this->error($e->getMessage());
          }
     }
}
