<?php

namespace Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Domain\Enums\Currency;
use Domain\Enums\PaymentFrequency;
use Domain\Rules\CounterpartAccountNumberRule;

class StandingOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bank_account_id' => ['required', 'exists:bank_accounts,id'],
            'counterpart_account_number' => ['required', new CounterpartAccountNumberRule(50)],
            'counterpart_bank_code' => ['required', 'string', 'max:10'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', Rule::in(array_column(Currency::cases(), 'value'))],
            'frequency' => ['required', Rule::in(array_column(PaymentFrequency::cases(), 'value'))],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ];
    }

}
