@extends('client.layout')

@section('title', 'Detail bankovního účtu')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Detail bankovního účtu</h3>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Číslo účtu:</strong> {{ $bankAccount->account_number }}/1100</p>
            <p><strong>Majitel:</strong> {{ $bankAccount->user->full_name }}</p>
            <p><strong>Měna:</strong> {{ $bankAccount->currency->value }}</p>
            <p><strong>Typ účtu:</strong> {{ $bankAccount->account_type->label() }}</p>
            <p><strong>Zůstatek:</strong> {{ $bankAccount->getFormattedBalance() }}</p>
            <p><strong>Datum založení:</strong> {{ $bankAccount->created_at->format('d.m.Y') }}</p>

            <form action="{{ route('admin.bank_accounts.destroy', $bankAccount) }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Opravdu chcete zrušit tento účet?')">
                    Zrušit účet
                </button>
            </form>
        </div>
    </div>

    <h4>Historie transakcí</h4>

    @include('client.components.transaction-table', [
        'transactions' => $bankAccount->transactions()->orderBy('created_at', 'desc')->get()
    ])
</div>
@endsection
