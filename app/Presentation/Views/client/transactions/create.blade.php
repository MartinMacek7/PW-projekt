@extends('client.layout')

@section('title', 'Nová transakce')

@section('content')
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Zadání platby</h3>
        </div>
        <div class="card-body">

            {{-- Chybové hlášky --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.create.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="bank_account_id" class="form-label">Vyberte účet</label>
                    <select class="form-select" id="bank_account_id" name="bank_account_id" required>
                        @foreach(auth()->user()->bankAccounts as $account)
                            <option value="{{ $account->id }}"
                                {{ old('bank_account_id', request('bank_account_id')) == $account->id ? 'selected' : '' }}>
                                {{ $account->account_number }} / {{ $account->bank_code }} ({{ $account->currency }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="counterparty_account_number" class="form-label">Číslo účtu příjemce</label>
                    <input type="text" class="form-control" id="counterparty_account_number" name="counterparty_account_number"
                           value="{{ old('counterparty_account_number') }}">
                </div>

                <div class="mb-3">
                    <label for="counterparty_bank_code" class="form-label">Kód banky</label>
                    <input type="text" class="form-control" id="counterparty_bank_code" name="counterparty_bank_code"
                           value="{{ old('counterparty_bank_code') }}">
                </div>

                <div class="mb-3">
                    <label for="vs" class="form-label">Variabilní symbol</label>
                    <input type="text" class="form-control" id="vs" name="vs" value="{{ old('vs') }}">
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Částka</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                </div>

                <div class="mb-3">
                    <label for="currency" class="form-label">Měna</label>
                    <select class="form-select" id="currency" name="currency">
                        @foreach(\App\Domain\Enums\Currency::cases() as $currency)
                            <option value="{{ $currency->value }}" {{ old('currency') == $currency->value ? 'selected' : '' }}>
                                {{ $currency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Zpráva pro příjemce</label>
                    <textarea class="form-control" id="message" name="message" rows="2">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Odeslat platbu</button>
            </form>
        </div>
    </div>
</div>
@endsection
