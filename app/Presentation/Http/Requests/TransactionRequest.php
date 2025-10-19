<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Domain\Enums\Currency;
use App\Domain\Models\User;
use App\Presentation\Http\Rules\CounterpartAccountNumberRule;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var  User $user */
        $user = Auth::user();
        $userBankAccountIds = $user->getBankAccounts()->pluck('id')->toArray() ?? [];

        return [
            'bank_account_id' => [
                'required',
                Rule::in($userBankAccountIds),
            ],
            'counterparty_account_number' => ['required', new CounterpartAccountNumberRule(50)],
            'counterparty_bank_code' => ['required', 'string', 'max:10'],
            'vs' => ['nullable', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', Rule::in(array_column(Currency::cases(), 'value'))],
            'message' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'bank_account_id.required' => 'Musíte vybrat svůj bankovní účet.',
            'bank_account_id.in' => 'Vybraný účet není platný.',
            'counterparty_account_number.required' => 'Číslo účtu příjemce je povinné.',
            'amount.required' => 'Částka je povinná.',
            'amount.numeric' => 'Částka musí být číslo.',
            'amount.min' => 'Částka musí být větší než 0.',
            'currency.required' => 'Měna je povinná.',
            'currency.in' => 'Vybraná měna není platná.',
        ];
    }
}
