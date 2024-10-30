<?php

namespace App\Interfaces\NotificationModule\Notification;

interface NotificationWriteInterface{
     public function create($request);
     public function make_notification_viewed($id);
}

?>