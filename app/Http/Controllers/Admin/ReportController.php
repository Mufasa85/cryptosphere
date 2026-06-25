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
use Illuminate\Support\Collection;

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
            // 🔥 PRÉPARER LES DONNÉES POUR L'EXPORT
            $exportData = $this->prepareCreditData($loans);
            return $this->exportCsv('credits', ['Reference', 'Client', 'Montant', 'Statut', 'Date'], $exportData);
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
            // 🔥 PRÉPARER LES DONNÉES FINANCIÈRES
            $exportData = collect([
                ['Indicateur' => 'Décaissé', 'Montant' => $disbursed],
                ['Indicateur' => 'Remboursé', 'Montant' => $repaid],
                ['Indicateur' => 'Intérêts', 'Montant' => $interest],
                ['Indicateur' => 'Pénalités', 'Montant' => $penalties],
                ['Indicateur' => 'Revenus', 'Montant' => $revenue],
                ['Indicateur' => 'Encours', 'Montant' => $outstanding],
            ]);
            return $this->exportCsv('financial', ['Indicateur', 'Montant'], $exportData);
        }

        return view('admin.reports.financial', compact('disbursed', 'repaid', 'interest', 'penalties', 'revenue', 'outstanding', 'monthly'));
    }

    /**
     * 🔥 NOUVELLE MÉTHODE: Préparer les données pour l'export CSV
     */
    protected function prepareCreditData($loans): Collection
    {
        return $loans->map(function ($loan) {
            return [
                'reference' => $loan->reference,
                'client' => $loan->user?->name ?? 'N/A',
                'montant' => number_format($loan->amount_requested, 0, ',', ' ') . ' FC',
                'statut' => $this->getStatusLabel($loan->status),
                'date' => $loan->created_at?->format('d/m/Y') ?? 'N/A',
            ];
        });
    }

    /**
     * 🔥 MÉTHODE UTILITAIRE: Labels des statuts
     */
    protected function getStatusLabel(string $status): string
    {
        return match($status) {
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'disbursed' => 'Décaissé',
            'rejected' => 'Rejeté',
            'repaid' => 'Remboursé',
            default => ucfirst($status),
        };
    }

    /**
     * 🔥 EXPORT CSV CORRIGÉ
     */
    protected function exportCsv(string $name, array $headers, $rows)
    {
        $callback = function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');

            // 🔥 Ajouter BOM pour UTF-8 (Excel compatible)
            fputs($file, "\xEF\xBB\xBF");

            // Écrire les en-têtes
            fputcsv($file, $headers);

            // Écrire les données
            foreach ($rows as $row) {
                // 🔥 VÉRIFICATION DE TYPE ROBUSTE
                if (is_object($row)) {
                    if (method_exists($row, 'toArray')) {
                        // Si c'est un modèle Eloquent
                        fputcsv($file, $row->toArray());
                    } else {
                        // Si c'est un objet stdClass
                        fputcsv($file, (array) $row);
                    }
                } elseif (is_array($row)) {
                    // Si c'est un tableau
                    fputcsv($file, $row);
                } else {
                    // Fallback
                    fputcsv($file, (array) $row);
                }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $name . '-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $name . '-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
