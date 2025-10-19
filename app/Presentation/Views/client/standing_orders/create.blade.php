@extends('layout')

@section('title', 'Nový trvalý příkaz')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Nový trvalý příkaz</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('standing_orders.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="bank_account_id" class="form-label">Účet</label>
            <select name="bank_account_id" id="bank_account_id" class="form-select">
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_number }}/1100</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Protiúčet</label>
                <input type="text" name="counterpart_account_number" class="form-control" value="{{ old('counterpart_account_number') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kód banky</label>
                <input type="text" name="counterpart_bank_code" class="form-control" value="{{ old('counterpart_bank_code') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Částka</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}">
            </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Měna</label>
            <select name="currency" class="form-select">
                @foreach (\App\Domain\Enums\Currency::cases() as $currency)
                    <option value="{{ $currency->value }}"
                        @selected(old('currency', 'CZK') === $currency->value)>
                        {{ $currency->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Frekvence</label>
            <select name="frequency" class="form-select">
                @foreach (\App\Domain\Enums\PaymentFrequency::cases() as $frequency)
                    <option value="{{ $frequency->value }}"
                        @selected((int) old('frequency', \App\Domain\Enums\PaymentFrequency::MONTHLY->value) === $frequency->value)>
                        {{ $frequency->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Datum začátku</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Datum konce</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary px-4">Uložit</button>
        </div>
    </form>
</div>
@endsection
