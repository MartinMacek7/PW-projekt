@extends('presentation::layout')

@section('title', 'Detail účtu')

@section('css')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-detail {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .card-detail:hover {
            transform: translateY(-5px);
        }
        .balance {
            font-size: 2rem;
            font-weight: bold;
            color: #198754;
        }
        .transaction-table th, .transaction-table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">Detail účtu</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-detail">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">
                        @if($account->account_type === \Domain\Enums\AccountType::CHECKING)
                            <i class="fa-solid fa-wallet me-2"></i>
                        @elseif($account->account_type === \Domain\Enums\AccountType::SAVINGS)
                            <i class="fa-solid fa-piggy-bank me-2"></i>
                        @endif
                        {{ $account->account_type->label() }}
                    </h5>

                    <p class="card-text mb-2"><strong>Číslo účtu:</strong> {{ $account->account_number }}/1100</p>
                    <p class="card-text mb-2"><strong>Měna:</strong> {{ $account->currency->value }}</p>
                    <p class="card-text mb-2"><strong>Majitel:</strong> {{ $account->user->full_name }}</p>
                    <p class="card-text mb-2"><strong>Datum založení:</strong> {{ $account->created_at->format('d.m.Y') }}</p>
                    <p class="card-text mb-3"><strong>Zůstatek:</strong> <span class="balance">{{ $account->getFormattedBalance() }}</span></p>

                    <a href="{{ route('accounts') }}" class="btn btn-secondary px-4 me-2">Zpět na účty</a>
                    <a href="{{ route('transactions.create', ['bank_account_id' => $account->id]) }}" class="btn btn-primary px-4 me-2">Nová transakce</a>
                    <a href="{{ route('accounts.pdf', $account->id) }}" class="btn btn-success">Stáhnout výpis</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-8">
    <h3 class="mt-5 mb-3 text-center">Historie transakcí</h3>

        @include('presentation::client.components.transaction-table', [
            'transactions' => $account->transactions()->orderBy('created_at','desc')->get()
        ])

</div>
@endsection
