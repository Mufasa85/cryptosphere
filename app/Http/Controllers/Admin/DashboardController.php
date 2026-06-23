<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function index()
    {
        $stats = $this->reportService->dashboardStats();
        $monthly = $this->reportService->monthlyLoanVolume();
        $status = $this->reportService->statusDistribution();

        return view('admin.dashboard', compact('stats', 'monthly', 'status'));
    }
}
