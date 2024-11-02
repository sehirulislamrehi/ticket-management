<?php

namespace App\Services\Pusher;

use Pusher;

class PusherService
{

     private function configuration()
     {
          $pusher_app_id = "1888514";
          $pusher_app_key = "b34d3e28d4bac1e13363";
          $pusher_app_secret = "8f87430a529f43e95146";

          return [
               "pusher_app_id" => $pusher_app_id,
               "pusher_app_key" => $pusher_app_key,
               "pusher_app_secret" => $pusher_app_secret,
          ];
     }

     public function trigger($params)
     {
          $configuration = $this->configuration();
          $pusher_app_id = $configuration['pusher_app_id'];
          $pusher_app_key = $configuration['pusher_app_key'];
          $pusher_app_secret = $configuration['pusher_app_secret'];

          $options = array(
               'cluster' => 'ap2',
               'useTLS' => true
          );
          $pusher = new Pusher\Pusher(
               $pusher_app_key,
               $pusher_app_secret,
               $pusher_app_id,
               $options
          );

          $data['status'] = 'success';
          $data['message'] = $params['message'];
          $data['data'] = $params['data'];
          $pusher->trigger($params['event'], 'my-event', $data);
     }
}
