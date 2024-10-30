<?php

namespace App\Repositories\ComplaintModule\Complaint;

use App\Enum\ComplaintCategoryEnum;
use App\Enum\ComplaintPriorityEnum;
use App\Enum\ComplaintStatusEnum;
use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Models\ComplaintModule\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintReadRepository implements ComplaintReadInterface
{

    protected $auth;

    public function __construct()
    {
        $this->auth = auth('web')->check() ? auth('web')->user() : Auth::guard("sanctum")->user();
    }

    public function fetch_all_complaint($params){
        $query = Complaint::query()->with("created_user");

        if( isset($params['user_id']) ){
            $query->where("created_by", $params['user_id']);
        }

        if( isset($params['title']) ){
            $query->where("title","LIKE","%".$params['title']."%");
        }

        if( isset($params['category']) ){
            $query->where("category", $params['category']);
        }

        if( isset($params['priority']) ){
            $query->where("priority", $params['priority']);
        }

        if( isset($params['status']) ){
            $query->where("status", $params['status']);
        }

        if( isset($params['submission_date']) ){
            $query->where("submission_date", $params['submission_date']);
        }

        if( isset($params['created_at']) ){
            $start = $params['created_at']." 00:00:00";
            $end = $params['created_at']." 23:59:59";
            $query->where("created_at",">=",$start)->where("created_at","<=",$end);
        }

        return $query->orderBy("id","desc");
    }

    public function fetch_complaint_by_id($id){

        if( Auth::guard('sanctum')->check() ){
            if($this->auth->is_super_admin){
                return Complaint::query()->where("id", $id)->with("created_user")->first();
            }
            else{
                return Complaint::query()->where("id", $id)->where("created_by",$this->auth->id)->with("created_user")->first();
            }
        }
        else{
            return Complaint::query()->where("id", $id)->with("created_user")->first();
        }
    }

    public function fetch_status_counting(){

        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        $open = (clone $query)->select("status")->where("status",ComplaintStatusEnum::open->value)->count();
        $in_progress = (clone $query)->select("status")->where("status",ComplaintStatusEnum::in_progress->value)->count();
        $resolved = (clone $query)->select("status")->where("status",ComplaintStatusEnum::resolved->value)->count();
        $closed = (clone $query)->select("status")->where("status",ComplaintStatusEnum::closed->value)->count();

        return [
            "open" => $open,
            "in_progress" => $in_progress,
            "resolved" => $resolved,
            "closed" => $closed,
        ];
        
    }

    public function fetch_priority_counting(){
        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        $low = (clone $query)->select("priority")->where("priority",ComplaintPriorityEnum::low->value)->count();
        $medium = (clone $query)->select("priority")->where("priority",ComplaintPriorityEnum::medium->value)->count();
        $high = (clone $query)->select("priority")->where("priority",ComplaintPriorityEnum::high->value)->count();

        return [
            "low" => $low,
            "medium" => $medium,
            "high" => $high,
        ];
    }

    public function fetch_category_counting(){
        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        $billing = (clone $query)->select("category")->where("category",ComplaintCategoryEnum::billing->value)->count();
        $service_issue = (clone $query)->select("category")->where("category",ComplaintCategoryEnum::service_issue->value)->count();
        $product_issue = (clone $query)->select("category")->where("category",ComplaintCategoryEnum::product_issue->value)->count();

        return [
            "billing" => $billing,
            "service_issue" => $service_issue,
            "product_issue" => $product_issue,
        ];
    }

    public function fetch_over_time_report(){
        $twoMonthsAgo = date('Y-m-01', strtotime('-2 months'));
        $data = DB::table('complaints')
            ->select(
                DB::raw('YEAR(complaints.created_at) as year'),
                DB::raw('MONTHNAME(complaints.created_at) as month'),
                DB::raw('COUNT(*) as total_tickets')
            )
            ->where('ticket_details.created_at', '>=', $twoMonthsAgo);
    }
}
