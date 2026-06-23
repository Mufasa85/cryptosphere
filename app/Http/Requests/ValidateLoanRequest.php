<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAgent() ?? false;
    }

    public function rules(): array
    {
        return [
            'amount_approved' => ['required', 'numeric', 'min:0'],
            'interest_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'duration_months' => ['required', 'integer', 'min:1', 'max:60'],
            'agent_notes' => ['nullable', 'string', 'max:2000'],
            'rejection_reason' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
