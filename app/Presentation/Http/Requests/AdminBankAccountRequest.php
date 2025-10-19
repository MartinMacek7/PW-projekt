<?php

namespace App\Presentation\Http\Requests;

use App\Domain\Enums\AccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminBankAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'account_type' => ['required', Rule::in(array_column(AccountType::cases(), 'value'))],
            'currency' => ['required', 'in:CZK,EUR,USD'],
        ];
    }
}
