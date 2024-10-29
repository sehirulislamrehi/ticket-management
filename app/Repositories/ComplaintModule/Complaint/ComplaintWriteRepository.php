<?php

namespace App\Repositories\ComplaintModule\Complaint;

use App\Enum\ComplaintStatusEnum;
use App\Interfaces\ComplaintModule\Complaint\ComplaintWriteInterface;
use App\Models\ComplaintModule\Complaint;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\FilePathTrait;

class ComplaintWriteRepository implements ComplaintWriteInterface
{

    use FilePathTrait;
    protected CommonService $common_service;
    protected $auth;

    public function __construct(CommonService $common_service)
    {
        $this->common_service = $common_service;
        $this->auth = auth('web')->user();
    }

    public function add($request){

        $auth = $this->auth;
        $complaint = new Complaint();

        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->category = $request->category;
        $complaint->priority = $request->priority;
        $complaint->status = $request->status;
        $complaint->created_by = $auth->id;
        $complaint->submission_date = $request->submission_date;

        if($request->status === ComplaintStatusEnum::resolved->value){
            $complaint->resolved_at = date("Y-m-d");
            $complaint->time_taken = $this->common_service->convert_two_date_to_second($complaint->resolved_at, $complaint->submission_date);
            $complaint->day_taken = $this->common_service->convert_second_to_day($complaint->time_taken);
        }
        else{
            $complaint->resolved_at = null;
            $complaint->time_taken = 0;
            $complaint->day_taken = 0;
        }

        $file = $request->file('image');
        $folder = $this->get_file_path("complaint");
        if($file){
            $filename = rand(00000,99999) .'_'. time() .'.'. $file->getClientOriginalExtension();
            if( $this->common_service->file_upload($file,$filename,$folder,null)){
                $complaint->image = $filename;
            }
        }

        return $complaint->save();
    }

    public function edit($request, $complaint){

        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->category = $request->category;
        $complaint->priority = $request->priority;
        $complaint->status = $request->status;
        $complaint->submission_date = $request->submission_date;

        if($request->status === ComplaintStatusEnum::resolved->value){
            $complaint->resolved_at = date("Y-m-d");
            $complaint->time_taken = $this->common_service->convert_two_date_to_second($complaint->resolved_at, $complaint->submission_date);
            $complaint->day_taken = $this->common_service->convert_second_to_day($complaint->time_taken);
        }
        else{
            $complaint->resolved_at = null;
            $complaint->time_taken = 0;
            $complaint->day_taken = 0;
        }

        $file = $request->file('image');
        $folder = $this->get_file_path("complaint");
        if($file){
            $filename = rand(00000,99999) .'_'. time() .'.'. $file->getClientOriginalExtension();
            if( $this->common_service->file_upload($file,$filename,$folder,null)){
                $complaint->image = $filename;
            }
        }

        if( $request->is_attachment_remove ){
            $this->common_service->remove_file($folder,$complaint->image,"public");
            $complaint->image = null;
       }

        return $complaint->save();
    }

}
