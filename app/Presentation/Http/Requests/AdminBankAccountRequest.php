<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'account_number' => ['required', 'string', 'max:20'],
            'account_type' => ['required', 'in:CHECKING,SAVINGS'],
            'currency' => ['required', 'in:CZK,EUR,USD'],
            'balance' => ['required', 'numeric', 'min:0'],
        ];
    }
}
