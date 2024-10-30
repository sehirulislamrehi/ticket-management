<?php

namespace App\Http\Controllers\Backend\ReportModule\Dashboard;

use App\Services\Backend\Modules\ReportingModule\Dashboard\DashboardReportService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardReportController extends Controller
{
    
    protected DashboardReportService $dashboard_report_service;

    public function __construct(DashboardReportService $dashboard_report_service)
    {
        $this->dashboard_report_service = $dashboard_report_service;
    }

    public function status_report(){
        return $this->dashboard_report_service->status_report();
    }

    public function priority_report(){
        return $this->dashboard_report_service->priority_report();
    }

    public function category_report(){
        return $this->dashboard_report_service->category_report();
    }

    public function over_time_report(){
        return $this->dashboard_report_service->over_time_report();
    }
}
