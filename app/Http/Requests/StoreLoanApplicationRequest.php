<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isClient() ?? false;
    }

    public function rules(): array
    {
        return [
            'amount_requested' => ['required', 'numeric', 'min:1000', 'max:10000000'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:60'],
            'interest_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'purpose' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount_requested.required' => 'Le montant demandé est obligatoire.',
            'amount_requested.numeric' => 'Le montant doit être un nombre.',
            'duration_months.required' => 'La durée est obligatoire.',
            'purpose.required' => 'Le motif du crédit est obligatoire.',
        ];
    }
}
