<?php

namespace Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'requested_amount' => ['required', 'numeric', 'min:1000'],
            'monthly_payment' => ['required', 'numeric', 'min:100'],
            'months' => ['required', 'integer', 'min:1'],
        ];
    }
}
