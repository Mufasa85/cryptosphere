<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\LoanSchedule;
use App\Models\Penalty;
use App\Models\Repayment;
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

    public function credits(Request $request)
    {
        $query = LoanApplication::with('user', 'agent')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15)->withQueryString();
        $stats = [
            'total' => LoanApplication::count(),
            'disbursed' => LoanApplication::where('status', 'disbursed')->count(),
            'repaid' => (float) Repayment::where('status', 'confirmed')->sum('amount'),
            'outstanding' => (float) LoanApplication::where('status', 'disbursed')->sum('amount_approved') - (float) Repayment::where('status', 'confirmed')->sum('amount'),
        ];

        if ($request->input('format') === 'csv') {
            return $this->exportCsv('credits', ['Reference', 'Client', 'Montant', 'Statut', 'Date'], $loans->map(fn ($loan) => [
                $loan->reference,
                $loan->user?->name,
                $loan->amount_requested,
                $loan->status,
                $loan->created_at?->format('d/m/Y'),
            ]));
        }

        return view('admin.reports.credits', compact('loans', 'stats'));
    }

    public function financial(Request $request)
    {
        $disbursed = (float) LoanApplication::where('status', 'disbursed')->sum('amount_approved');
        $repaid = (float) Repayment::where('status', 'confirmed')->sum('amount');
        $interest = (float) LoanSchedule::where('status', 'paid')->sum('interest_amount');
        $penalties = (float) Penalty::where('status', 'paid')->sum('amount');
        $revenue = $interest + $penalties;
        $outstanding = $disbursed - $repaid;

        $monthly = LoanApplication::selectRaw("DATE_FORMAT(disbursed_at, '%Y-%m') as month, sum(amount_approved) as amount")
            ->whereNotNull('disbursed_at')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get();

        if ($request->input('format') === 'csv') {
            return $this->exportCsv('financial', ['Indicateur', 'Montant'], collect([
                ['Décaissé', $disbursed],
                ['Remboursé', $repaid],
                ['Intérêts', $interest],
                ['Pénalités', $penalties],
                ['Revenus', $revenue],
                ['Encours', $outstanding],
            ]));
        }

        return view('admin.reports.financial', compact('disbursed', 'repaid', 'interest', 'penalties', 'revenue', 'outstanding', 'monthly'));
    }

    protected function exportCsv(string $name, array $headers, $rows)
    {
        $callback = function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($rows as $row) {
                fputcsv($file, $row->toArray());
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $name . '-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
