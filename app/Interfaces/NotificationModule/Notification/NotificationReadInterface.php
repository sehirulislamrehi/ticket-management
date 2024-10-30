<?php

namespace App\Interfaces\NotificationModule\Notification;

interface NotificationReadInterface{
     public function fetch_all_notification($params);
     public function fetch_notification_by_id($id);
}

?>