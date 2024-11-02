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
        $auth = $this->auth;
        $query = Complaint::query()->with("created_user");

        if(!$this->auth->is_super_admin){
            $query->where("created_by", $auth->id);
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

        $auth = $this->auth;
        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->select("status","created_by")->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        $open_query = (clone $query)->where("status",ComplaintStatusEnum::open->value);
        $in_progress_query = (clone $query)->where("status",ComplaintStatusEnum::in_progress->value);
        $resolved_query = (clone $query)->where("status",ComplaintStatusEnum::resolved->value);
        $closed_query = (clone $query)->where("status",ComplaintStatusEnum::closed->value);

        if(!$auth->is_super_admin){
            $open_query = $open_query->where("created_by", $auth->id);
            $in_progress_query = $in_progress_query->where("created_by", $auth->id);
            $resolved_query = $resolved_query->where("created_by", $auth->id);
            $closed_query = $closed_query->where("created_by", $auth->id);
        }

        $open = $open_query->count();
        $in_progress = $in_progress_query->count();
        $resolved = $resolved_query->count();
        $closed = $closed_query->count();

        return [
            "open" => $open,
            "in_progress" => $in_progress,
            "resolved" => $resolved,
            "closed" => $closed,
        ];
        
    }

    public function fetch_priority_counting(){
        $auth = $this->auth;
        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->select("priority","created_by")->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        if(!$auth->is_super_admin){
            $query = $query->where("created_by", $auth->id);
        }

        $low = (clone $query)->where("priority",ComplaintPriorityEnum::low->value)->count();
        $medium = (clone $query)->where("priority",ComplaintPriorityEnum::medium->value)->count();
        $high = (clone $query)->where("priority",ComplaintPriorityEnum::high->value)->count();

        return [
            "low" => $low,
            "medium" => $medium,
            "high" => $high,
        ];
    }

    public function fetch_category_counting(){
        $auth = $this->auth;
        $today = Carbon::today()->format('Y-m-d') ." 23:59:59";
        $thirty_days_before = Carbon::today()->subDays(30)->format('Y-m-d') ." 00:00:00";
        $query = Complaint::query()->select("category","created_by")->where("created_at",">=",$thirty_days_before)->where("created_at","<=",$today)->get();

        if(!$auth->is_super_admin){
            $query = $query->where("created_by", $auth->id);
        }

        $billing = (clone $query)->where("category",ComplaintCategoryEnum::billing->value)->count();
        $service_issue = (clone $query)->where("category",ComplaintCategoryEnum::service_issue->value)->count();
        $product_issue = (clone $query)->where("category",ComplaintCategoryEnum::product_issue->value)->count();

        return [
            "billing" => $billing,
            "service_issue" => $service_issue,
            "product_issue" => $product_issue,
        ];
    }

    public function fetch_over_time_report(){
        $auth = $this->auth;
        $twoMonthsAgo = now()->subMonths(4)->startOfMonth();
        $resolved = ComplaintStatusEnum::resolved->value;
        $closed = ComplaintStatusEnum::closed->value;
        $query = DB::table('complaints')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('COUNT(*) as complaint_submitted'),
                DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as total_resolved'), 
                DB::raw('SUM(CASE WHEN status = "closed" THEN 1 ELSE 0 END) as total_closed'),
                DB::raw('MAX(created_at) as latest_created_at') // Use MAX to get the latest date within each group
            )
            ->where('created_at', '>=', $twoMonthsAgo);
        
        if (!$auth->is_super_admin) {
            $query->where("created_by", $auth->id);
        }
        
        return $query->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('latest_created_at', 'asc') // Use latest_created_at for ordering
            ->get();


    }
}
