<?php

namespace App\Services\Backend\Modules\NotificationModule\Notification;

use App\Interfaces\NotificationModule\Notification\NotificationReadInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Models\NotificationModule\Notification;
use App\Traits\ApiResponseTrait;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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

     public function my_notification()
     {
          try {
               $params = [
                    "per_page_data" => 10,
                    "is_viewed" => false,
               ];
               $data = $this->notification_read_repository->fetch_all_notification($params);
               return $this->success($data->get(), "Notification data");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function make_notification_view($id)
     {
          try {
               $auth = $this->auth;
               $notification = $this->notification_read_repository->fetch_notification_by_id($id);

               if (!$auth->is_super_admin) {
                    if ($auth->id != $notification->to_user_id) {
                         return $this->warning(null, "You can't update another user notification");
                    }
               }

               $this->notification_write_repository->make_notification_viewed($id);
               return $this->success(null, "Notification updated");
          } catch (Exception $e) {
               return $this->error(null, $e->getMessage());
          }
     }

     public function index()
     {
          try {
               return view("backend.modules.notification_module.notification.index");
          } catch (Exception $e) {
               return back()->with('error', $e->getMessage());
          }
     }

     public function data()
     {
          try {
               $params = [];
               $datas = $this->notification_read_repository->fetch_all_notification($params);
               return $this->make_notification_datatable($datas);
          } catch (Exception $e) {
               return $e->getMessage();
          }
     }

     public function make_notification_datatable($data)
     {
          try{
               return DataTables::of($data)
               ->addIndexColumn()
               ->order(function ($data) {
                    $data->orderBy('id', 'desc');  // Apply ordering here
               })
               ->rawColumns(['action', 'message','is_viewed'])
               ->editColumn('message', function (Notification $data) {
                    if ($data->link) {
                         return "<a href='{$data->link}' target='_blank'>{$data->message}</a>";
                    } else {
                         return $data->message;
                    }
               })
               ->editColumn('is_viewed', function (Notification $data) {
                    if ($data->is_viewed) {
                         return "<span class='badge badge-success'><i class='fas fa-eye-slash'></i></span>";
                    } else {
                         return "<span class='badge badge-success'><i class='fas fa-eye' data-icon='true' style='cursor: pointer' onclick='handleNotificationClick({$data->id}, this)'></i></span>";
                    }
               })
               ->addColumn('action', function (Notification $data) {
                    return '
                    <div class="dropdown">
                         <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown' . $data->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                         </button>
                         <div class="dropdown-menu" aria-labelledby="dropdown' . $data->id . '">
                         
                              <a class="dropdown-item" href="#" data-content="' . route('notification.delete.modal', $data->id) . '" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                   <i class="fas fa-trash"></i>
                                   Delete
                              </a>

                         </div>
                    </div>
                    ';
               })
               ->make(true);
          }
          catch( Exception $e ){
               return $e->getMessage();
          }
     }

     public function delete_modal($id){
          try {
               $notification = $this->notification_read_repository->fetch_notification_by_id($id);
               if(!$notification){
                    return "No notification found";
               }

               $title = Str::limit($notification->message,50,'...');
               return view("backend.modules.notification_module.notification.modals.delete", compact("notification","title"));
          } catch (Exception $e) {
               return $e->getMessage();
          }
     }

     public function delete($id){
          try {
               $notification = $this->notification_read_repository->fetch_notification_by_id($id);
               if(!$notification){
                    return $this->warning(null,"No notification found");
               }

               $this->notification_write_repository->delete_notification($id);

               return $this->success(null,"Notification removed");
          } catch (Exception $e) {
               return $this->error(null,$e->getMessage());
          }
     }
}
