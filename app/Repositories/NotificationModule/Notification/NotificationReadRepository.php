<?php

namespace App\Repositories\NotificationModule\Notification;

use App\Interfaces\NotificationModule\Notification\NotificationReadInterface;
use App\Models\NotificationModule\Notification;

class NotificationReadRepository implements NotificationReadInterface{

     protected $auth;
     public function __construct()
     {
          $this->auth = auth('web')->user();
     }

     public function fetch_all_notification($params){
          $auth = $this->auth;
          $query = Notification::query()->select("id","message","is_viewed","link")->where("to_user_id", $auth->id);

          if( isset($params['is_viewed']) ){
               $query = $query->where("is_viewed", $params['is_viewed']);
          }
          if( isset($params['per_page_data']) ){
               $query = $query->take($params['per_page_data']);
          }

          return $query->orderBy("id","desc");
     }

     public function fetch_notification_by_id($id){
          return Notification::where("id", $id)->first();
     }
}

?>