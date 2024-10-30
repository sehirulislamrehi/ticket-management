<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\DashboardService;

class DashboardController extends Controller
{

    protected DashboardService $dashboard_service;

    public function __construct(DashboardService $dashboard_service)
    {
        $this->dashboard_service = $dashboard_service;
    }

    public function index(){
        return $this->dashboard_service->index();
    }
}
