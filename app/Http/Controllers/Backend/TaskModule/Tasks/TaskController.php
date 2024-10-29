<?php

namespace App\Http\Controllers\Backend\TaskModule\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\TaskModule\Task\CreateTaskRequest;
use App\Http\Requests\Backend\Modules\TaskModule\Task\EditTaskRequest;
use App\Interfaces\TaskModule\Tasks\TaskReadInterface;
use App\Interfaces\TaskModule\Tasks\TaskWriteInterface;
use App\Interfaces\UserModule\User\UserReadInterface;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Services\Backend\Modules\TaskModule\TaskService;
use App\Traits\ApiResponseTrait;
use App\Traits\FilePathTrait;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    use ApiResponseTrait, FilePathTrait;
    protected $task_read_repository;
    protected $task_write_repository;
    protected $task_service;
    protected $user_read_repository;
    protected $common_service;

    public function __construct(TaskReadInterface $task_read_interface, TaskWriteInterface $task_write_interface, TaskService $task_service, UserReadInterface $user_read_interface, CommonService $common_service)
    {
        $this->task_read_repository = $task_read_interface;
        $this->task_write_repository = $task_write_interface;
        $this->task_service = $task_service;
        $this->user_read_repository = $user_read_interface;
        $this->common_service = $common_service;
    }

    public function index(){
        try{
            if (can('task_list')) {
                $all_task_status = $this->task_service->get_task_status();
                return view("backend.modules.task_module.tasks.index", compact("all_task_status"));
            } else {
                return view("errors.403");
            }
        }
        catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function data(Request $request){
        try{
            if (can('task_list')) {
                $tasks = $this->task_read_repository->get_all_task($request);
                return $this->task_read_repository->task_datatable($tasks);
            } 
            else {
                return unauthorized();
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function add_modal(){
        try{
            if(can("add_task")){
                $all_task_status = $this->task_service->get_task_status();
                return view("backend.modules.task_module.tasks.modals.add", compact("all_task_status"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function get_user_by_email($email){
        try{
            if(can("add_task")){
                $users = $this->user_read_repository->get_user_by_email($email);
                return $this->success($users, "User data");
            }
            else{
                return $this->warning(null, unauthorized());
            }
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function add(CreateTaskRequest $request){
        try{
            if(can("add_task")){
                return $this->task_write_repository->create($request);
            }
            else{
                return $this->warning(null, unauthorized());
            }
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function edit_modal($id){
        try{
            if(can("edit_task")){
                $task = $this->task_read_repository->get_task_by_id($id);
                if(!$task){
                    return "No task found.";
                }
                $all_task_status = $this->task_service->get_task_status();
                $image_link = $this->common_service->get_image_link($task->image,$this->get_file_path("task"));
                return view("backend.modules.task_module.tasks.modals.edit", compact("task","all_task_status","image_link"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function edit(EditTaskRequest $request, $id){
        try{
            if(can("edit_task")){
                $task = $this->task_read_repository->get_task_by_id($id);
                if(!$task){
                    return $this->warning(null, "No task found.");
                }
                return $this->task_write_repository->edit($request, $task);
            }
            else{
                return $this->warning(null, unauthorized());
            }
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function delete_modal($id){
        try{
            if(can("delete_task")){
                $task = $this->task_read_repository->get_task_by_id($id);
                if(!$task){
                    return "No task found.";
                }
                return view("backend.modules.task_module.tasks.modals.delete", compact("task"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function delete($id){
        try{
            if(can("delete_task")){
                $task = $this->task_read_repository->get_task_by_id($id);
                if(!$task){
                    return $this->warning(null, "No task found.");
                }
                return $this->task_write_repository->delete($task);
            }
            else{
                return $this->warning(null, unauthorized());
            }
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function details($id){
        try{
            if(can("task_list")){
                $task = $this->task_read_repository->get_task_by_id($id);
                if(!$task){
                    return "No task found.";
                }
                $image_link = $this->common_service->get_image_link($task->image,$this->get_file_path("task"));
                $time_taken = $this->common_service->convert_second_to_hour_minute($task->time_taken);
                return view("backend.modules.task_module.tasks.modals.details", compact("task","image_link", "time_taken"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }
}
