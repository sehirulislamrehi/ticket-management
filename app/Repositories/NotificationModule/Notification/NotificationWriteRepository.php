<?php

namespace App\Repositories\NotificationModule\Notification;

use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Models\NotificationModule\Notification;
use Illuminate\Support\Facades\DB;

class NotificationWriteRepository implements NotificationWriteInterface{


     public function create($request){
          return DB::table("notifications")->insert($request);
     }

     public function make_notification_viewed($id){
          return Notification::where("id",$id)->update([
               "is_viewed" => true
          ]);
     }

     public function delete_notification($id){
          return Notification::where("id", $id)->delete();
     }

}

?>