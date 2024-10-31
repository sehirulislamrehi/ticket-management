<?php

namespace App\Http\Controllers\Backend\NotificationModule\Notification;

use App\Http\Controllers\Controller;
use App\Services\Backend\Modules\NotificationModule\Notification\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    protected NotificationService $notification_service;

    public function __construct(NotificationService $notification_service)
    {
        $this->notification_service = $notification_service;
    }

    public function my_notification(){
        return $this->notification_service->my_notification();
    }

    public function make_notification_view($id){
        return $this->notification_service->make_notification_view($id);
    }

    public function index(){
        return $this->notification_service->index();
    }

    public function data(){
        return $this->notification_service->data();
    }

    public function delete_modal($id){
        return $this->notification_service->delete_modal($id);
    }
    public function delete($id){
        return $this->notification_service->delete($id);
    }
}
