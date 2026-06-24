<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LoanApplication;
use App\Models\Repayment;
use App\Services\MobileMoney\LabPayService;
use App\Services\MobileMoney\MockService;
use App\Services\RepaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepaymentController extends Controller
{
    public function __construct(
        protected RepaymentService $repaymentService,
    ) {}

    public function index()
    {
        $repayments = auth()->user()
            ->repayments()
            ->with('loanApplication')
            ->latest()
            ->paginate(10);

        return view('client.repayments.index', compact('repayments'));
    }

    public function create(LoanApplication $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        return view('client.repayments.create', compact('loan'));
    }

    public function store(Request $request, LoanApplication $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'mobile_number' => ['required', 'string', 'max:20'],
        ]);

        $repayment = DB::transaction(function () use ($loan, $data) {
            $repayment = $this->repaymentService->createPending(
                $loan,
                (float) $data['amount'],
                $data['mobile_number']
            );

            $gateway = config('services.labpay.provider') === 'labpay'
                ? app(LabPayService::class)
                : app(MockService::class);

            $response = $gateway->initiate(
                $repayment->mobile_number,
                (float) $repayment->amount,
                $repayment->id
            );

            $repayment->transactions()->create([
                'provider' => $response['provider'] ?? 'mock',
                'provider_reference' => $response['provider_reference'] ?? null,
                'request_payload' => [
                    'amount' => $repayment->amount,
                    'mobile_number' => $repayment->mobile_number,
                ],
                'response_payload' => $response,
                'status' => $gateway->isSuccess($response) ? 'success' : 'failed',
            ]);

            if ($gateway->isSuccess($response)) {
                $this->repaymentService->confirm($repayment);
                ActivityLog::record('repayment.confirmed', $repayment, 'Remboursement confirmé');
            }

            return $repayment;
        });

        return redirect()->route('client.repayments.index')
            ->with('success', 'Paiement ' . ($repayment->isConfirmed() ? 'confirmé' : 'en attente') . '.');
    }

    public function receipt(Repayment $repayment)
    {
        if ($repayment->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('repayment'));

        return $pdf->download('recu-' . $repayment->id . '.pdf');
    }
}
