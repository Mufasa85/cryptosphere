<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LoanApplication;
use App\Models\Repayment;
use App\Services\RepaymentService;
use Illuminate\Http\Request;

class RepaymentController extends Controller
{
    public function __construct(protected RepaymentService $repaymentService) {}

    public function index()
    {
        $repayments = Repayment::with('user', 'loanApplication')
            ->latest()
            ->paginate(15);

        return view('agent.repayments.index', compact('repayments'));
    }

    public function create()
    {
        $loans = LoanApplication::active()
            ->with('user')
            ->whereHas('schedules', function ($query) {
                $query->unpaid();
            })
            ->get();

        return view('agent.repayments.create', compact('loans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'loan_application_id' => ['required', 'exists:loan_applications,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'string', 'in:mobile_money,cash,bank_transfer'],
            'mobile_number' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:pending,confirmed'],
        ]);

        $loan = LoanApplication::findOrFail($data['loan_application_id']);

        $repayment = $loan->repayments()->create([
            'user_id' => $loan->user_id,
            'loan_schedule_id' => $loan->schedules()->unpaid()->first()?->id,
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'mobile_number' => $data['mobile_number'] ?? $loan->user->phone,
            'status' => $data['status'],
            'paid_at' => $data['status'] === 'confirmed' ? now() : null,
        ]);

        if ($data['status'] === 'confirmed') {
            $this->repaymentService->confirm($repayment);
        }

        ActivityLog::record('repayment.collected', $repayment, 'Encaissement par agent');

        return redirect()->route('agent.repayments.index')
            ->with('success', 'Remboursement enregistré.');
    }
}
