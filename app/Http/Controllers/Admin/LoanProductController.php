<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LoanProduct;
use Illuminate\Http\Request;

class LoanProductController extends Controller
{
    public function index()
    {
        $products = LoanProduct::latest()->paginate(15);

        return view('admin.settings.loan_products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.settings.loan_products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0'],
            'interest_rate' => ['required', 'numeric', 'min:0'],
            'duration_months' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $product = LoanProduct::create($data);

        ActivityLog::record('loan_product.created', $product, 'Type de crédit créé');

        return redirect()->route('admin.settings.loan-products.index')
            ->with('success', 'Type de crédit créé.');
    }

    public function edit(LoanProduct $loanProduct)
    {
        return view('admin.settings.loan_products.edit', compact('loanProduct'));
    }

    public function update(Request $request, LoanProduct $loanProduct)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0'],
            'interest_rate' => ['required', 'numeric', 'min:0'],
            'duration_months' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $loanProduct->update($data);

        ActivityLog::record('loan_product.updated', $loanProduct, 'Type de crédit mis à jour');

        return redirect()->route('admin.settings.loan-products.index')
            ->with('success', 'Type de crédit mis à jour.');
    }

    public function destroy(LoanProduct $loanProduct)
    {
        $loanProduct->delete();

        ActivityLog::record('loan_product.deleted', null, 'Type de crédit supprimé : ' . $loanProduct->name);

        return redirect()->route('admin.settings.loan-products.index')
            ->with('success', 'Type de crédit supprimé.');
    }
}
