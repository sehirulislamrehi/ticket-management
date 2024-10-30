<?php

namespace App\Services\Backend\Modules\ReportingModule\Dashboard;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Traits\ApiResponseTrait;
use Exception;

class DashboardReportService
{

    use ApiResponseTrait;
    protected ComplaintReadInterface $complaint_read_repository;

    public function __construct(
        ComplaintReadInterface $complaint_read_interface
    ) {
        $this->complaint_read_repository = $complaint_read_interface;
    }

    public function status_report()
    {
        try {
            $datas = $this->complaint_read_repository->fetch_status_counting();
            return $this->success($datas, "Status report");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function priority_report()
    {
        try {
            $datas = $this->complaint_read_repository->fetch_priority_counting();
            return $this->success($datas, "Priority report");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function category_report()
    {
        try {
            $datas = $this->complaint_read_repository->fetch_category_counting();
            return $this->success($datas, "Category report");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }

    public function over_time_report()
    {
        try {
            $datas = $this->complaint_read_repository->fetch_over_time_report();
            return $this->success($datas, "Overtime report");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage());
        }
    }
}
