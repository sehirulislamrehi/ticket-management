<?php

namespace App\Http\Controllers\Backend\ReportModule\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\TaskModule\Tasks\TaskReadInterface;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class DashboardReportController extends Controller
{
    
    use ApiResponseTrait;
    protected $task_read_repository;

    public function __construct(TaskReadInterface $task_read_interface)
    {
        $this->task_read_repository = $task_read_interface;   
    }

    public function task_counting(){
        try{
            $response = $this->task_read_repository->get_task_counting();
            return $this->success($response, "Task counting");
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function highest_complete_task_user(){
        try{
            $response = $this->task_read_repository->get_highest_task_solve_user_list();
            return $this->success($response, "Highest complete task user");
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }

    public function highest_average_time_taken_user(){
        try{
            $response = $this->task_read_repository->get_highest_average_time_taken_user();
            return $this->success($response, "Highest average time taken user");
        }
        catch( Exception $e ){
            return $this->error(null, $e->getMessage());
        }
    }
}
