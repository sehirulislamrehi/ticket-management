<?php

namespace App\Services\Backend\Modules\ComplaintModule\Complaint;

use App\Enum\ComplaintCategoryEnum;
use App\Enum\ComplaintPriorityEnum;
use App\Enum\ComplaintStatusEnum;
use App\Events\NotificationModule\SendNotificationEvent;
use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Interfaces\ComplaintModule\Complaint\ComplaintWriteInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Models\ComplaintModule\Complaint;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Services\Pusher\PusherService;
use App\Traits\ApiResponseTrait;
use App\Traits\FilePathTrait;
use Carbon\Carbon;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class ComplaintService
{

    use ApiResponseTrait, FilePathTrait;

    protected ComplaintReadInterface $complaint_read_repository;
    protected ComplaintWriteInterface $complaint_write_repository;
    protected NotificationWriteInterface $notification_write_repository;
    protected CommonService $common_service;
    protected $auth;
    protected PusherService $pusher_service;

    public function __construct(
        ComplaintReadInterface $complaint_read_interface,
        ComplaintWriteInterface $complaint_write_interface,
        CommonService $common_service,
        NotificationWriteInterface $notification_write_interface,
        PusherService $pusher_service
    ) {
        $this->complaint_read_repository = $complaint_read_interface;
        $this->complaint_write_repository = $complaint_write_interface;
        $this->common_service = $common_service;
        $this->notification_write_repository = $notification_write_interface;
        $this->pusher_service = $pusher_service;
        $this->auth = auth('web')->user();
    }

    public function index()
    {
        if (can('complaint')) {
            try {
                $complaint_category = $this->get_complaint_category();
                $complaint_priority = $this->get_complaint_priority();
                $complaint_status = $this->get_complaint_status();
                return view("backend.modules.complaint_module.complaint.index", compact("complaint_category", "complaint_priority", "complaint_status"));
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        } else {
            return view("errors.403");
        }
    }

    public function data($request)
    {
        if (can('complaint')) {
            try {
                $complaints = $this->complaint_read_repository->fetch_all_complaint($request);
                return $this->make_complaint_datatable($complaints);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return unauthorized();
        }
    }

    public function make_complaint_datatable($complaints)
    {

        $complaint_category = $this->get_complaint_category();
        $complaint_priority = $this->get_complaint_priority();
        $complaint_status = $this->get_complaint_status();

        return DataTables::of($complaints)
            ->addIndexColumn()
            ->order(function ($complaints) {
                $complaints->orderBy('id', 'desc');  // Apply ordering here
            })
            ->rawColumns(['action', 'category', 'priority', 'created_by', 'resolved_at', 'time_taken', 'created_at'])
            ->editColumn('category', function (Complaint $complaint) use ($complaint_category) {
                $category = collect($complaint_category)->where("key", $complaint->category)->first();
                return $category['label'];
            })
            ->editColumn('priority', function (Complaint $complaint) use ($complaint_priority) {
                $priority = collect($complaint_priority)->where("key", $complaint->priority)->first();
                return $priority['label'];
            })
            ->editColumn('status', function (Complaint $complaint) use ($complaint_status) {
                $status = collect($complaint_status)->where("key", $complaint->status)->first();
                return $status['label'];
            })
            ->editColumn('created_by', function (Complaint $complaint) {
                return $complaint->created_user->name;
            })
            ->editColumn('resolved_at', function (Complaint $complaint) {
                return $complaint->resolved_at ?? 'Not Resolved Yet';
            })
            ->editColumn('time_taken', function (Complaint $complaint) {
                return $this->common_service->convert_second_to_hour_minute($complaint->time_taken);
            })
            ->editColumn('created_at', function (Complaint $complaint) {
                return $complaint->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function (Complaint $complaints) {
                return '
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown' . $complaints->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdown' . $complaints->id . '">
            
                ' . (can("complaint") ? '
                <a class="dropdown-item" href="#" data-content="' . route('complaint.details', encrypt($complaints->id)) . '" data-target="#largeModal" class="btn btn-outline-dark" data-toggle="modal">
                    <i class="fas fa-eye"></i>
                    View
                </a>
                ' : '') . '

                ' . (can("edit_complaint") ? '
                <a class="dropdown-item" href="#" data-content="' . route('complaint.edit.modal', encrypt($complaints->id)) . '" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                ' : '') . '

            </div>
        </div>
        ';
            })
            ->make(true);
    }

    public function add_modal()
    {
        if (can("add_complaint")) {
            try {
                $complaint_category = $this->get_complaint_category();
                $complaint_priority = $this->get_complaint_priority();
                $complaint_status = $this->get_complaint_status();
                return view("backend.modules.complaint_module.complaint.modals.add", compact("complaint_category", "complaint_priority", "complaint_status"));
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return unauthorized();
        }
    }

    public function add($request)
    {
        if (can("add_complaint")) {
            try {
                $auth = $this->auth;

                $this->complaint_write_repository->add($request);

                
                //save notification for update complaint successfully
                $params = [
                    "from_user_id" => $auth->id,
                    "to_user_id" => $auth->id,
                    "message" => "New complaint '{$request->title}' is created.",
                    "is_viewed" => false,
                    "link" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];
                $this->notification_write_repository->create($params);

                //trigger pusher for real time notification alert
                $pusher_params = [
                    "to_user_id" => $auth->id,
                    "message" => $params['message'],
                    "data" => [],
                    "event" => "notification-{$auth->id}"
                ];
                $this->pusher_service->trigger($pusher_params);

                return $this->success(null, "Complaint created");
            } catch (Exception $e) {
                return $this->error(null, $e->getMessage());
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }

    public function edit_modal($id)
    {
        if (can("edit_complaint")) {
            try {
                $complaint_category = $this->get_complaint_category();
                $complaint_priority = $this->get_complaint_priority();
                $complaint_status = $this->get_complaint_status();
                $id = decrypt($id);
                $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
                if (!$complaint) {
                    return "No complaint found";
                }
                $image_link = $this->common_service->get_image_link($complaint->image, $this->get_file_path("complaint"));

                return view("backend.modules.complaint_module.complaint.modals.edit", compact("complaint_category", "complaint_priority", "complaint_status", "complaint", "image_link"));
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return unauthorized();
        }
    }

    public function edit($request, $id)
    {
        if (can("edit_complaint")) {
            try {

                $auth = $this->auth;
                $id = decrypt($id);
                $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
                if (!$complaint) {
                    return "No complaint found";
                }

                $this->complaint_write_repository->edit($request, $complaint);

                //save notification for update complaint successfully
                if($auth->id != $complaint->created_by){

                    $params = [
                        "from_user_id" => $auth->id,
                        "to_user_id" => $auth->id,
                        "message" => "'{$request->title}' complaint is updated.",
                        "is_viewed" => false,
                        "link" => null,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    ];
                    $this->notification_write_repository->create($params);
                    //trigger pusher for real time notification alert
                    $pusher_params = [
                        "to_user_id" => $auth->id,
                        "message" => $params['message'],
                        "data" => [],
                        "event" => "notification-{$auth->id}"
                    ];
                    $this->pusher_service->trigger($pusher_params);
                }

                //save notification for update complaint successfully
                $params = [
                    "from_user_id" => $auth->id,
                    "to_user_id" => $complaint->created_by,
                    "message" => "'{$request->title}' complaint is updated.",
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

                return $this->success(null, "Complaint updated");
            } catch (Exception $e) {
                return $this->error(null, $e->getMessage());
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }

    public function details($id)
    {
        if (can("complaint")) {
            try {
                $complaint_category = $this->get_complaint_category();
                $complaint_priority = $this->get_complaint_priority();
                $complaint_status = $this->get_complaint_status();
                $id = decrypt($id);
                $complaint = $this->complaint_read_repository->fetch_complaint_by_id($id);
                if (!$complaint) {
                    return "No complaint found";
                }
                $image_link = $this->common_service->get_image_link($complaint->image, $this->get_file_path("complaint"));
                $time_taken = $this->common_service->convert_second_to_hour_minute($complaint->time_taken);
                $category = collect($complaint_category)->where("key", $complaint->category)->first();
                $priority = collect($complaint_priority)->where("key", $complaint->priority)->first();
                $status = collect($complaint_status)->where("key", $complaint->status)->first();
                $auth = $this->auth;

                return view("backend.modules.complaint_module.complaint.modals.details", compact("complaint_category", "complaint_priority", "complaint_status", "complaint", "image_link", "time_taken", "category", "priority", "status", "auth"));
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return unauthorized();
        }
    }

    public function get_complaint_category()
    {
        return array_map(
            fn($enum) => [
                'key' => $enum->value,
                'label' => $enum->label(),
            ],
            ComplaintCategoryEnum::cases()
        );
    }

    public function get_complaint_priority()
    {
        return array_map(
            fn($enum) => [
                'key' => $enum->value,
                'label' => $enum->label(),
            ],
            ComplaintPriorityEnum::cases()
        );
    }

    public function get_complaint_status()
    {
        return array_map(
            fn($enum) => [
                'key' => $enum->value,
                'label' => $enum->label(),
            ],
            ComplaintStatusEnum::cases()
        );
    }
}
