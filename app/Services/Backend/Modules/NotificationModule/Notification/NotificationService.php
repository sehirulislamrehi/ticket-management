<?php

namespace App\Services\Backend\Modules\NotificationModule\Notification;

use App\Interfaces\NotificationModule\Notification\NotificationReadInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Traits\ApiResponseTrait;
use Exception;

class NotificationService
{

     use ApiResponseTrait;

     protected NotificationReadInterface $notification_read_repository;
     protected NotificationWriteInterface $notification_write_repository;
     protected $auth;

     public function __construct(NotificationReadInterface $notification_read_interface, NotificationWriteInterface $notification_write_interface)
     {
          $this->notification_read_repository = $notification_read_interface;
          $this->notification_write_repository = $notification_write_interface;
          $this->auth = auth('web')->user();

     }

     public function my_notification() {
          try{
               $params = [
                    "per_page_data" => 10,
                    "is_viewed" => false,
               ];
               $data = $this->notification_read_repository->fetch_all_notification($params);
               return $this->success($data->get(),"Notification data");
          }
          catch( Exception $e ){
               return $this->error(null, $e->getMessage());
          }
     }

     public function make_notification_view($id){
          try{
               $auth = $this->auth;
               $notification = $this->notification_read_repository->fetch_notification_by_id($id);

               if(!$auth->is_super_admin){
                    if( $auth->id != $notification->to_user_id ){
                         return $this->warning(null,"You can't update another user notification");
                    }
               }

               $this->notification_write_repository->make_notification_viewed($id);
               return $this->success(null,"Notification updated");

          }
          catch( Exception $e ){
               return $this->error(null, $e->getMessage());
          }
     }
}
