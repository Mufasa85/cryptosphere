<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function index(Request $request)
    {
        $stats = $this->reportService->dashboardStats();
        $monthly = $this->reportService->monthlyLoanVolume();
        $status = $this->reportService->statusDistribution();

        if ($request->input('format') === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.pdf', compact('stats', 'monthly', 'status'));

            return $pdf->download('rapport-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('admin.reports.index', compact('stats', 'monthly', 'status'));
    }
}
