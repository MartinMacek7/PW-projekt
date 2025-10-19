@extends('layout')

@section('title', 'Detail transakce')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Detail transakce #{{ $transaction->id }}</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Klient:</strong> {{ $transaction->bankAccount->user->full_name }}</p>
            <p><strong>Číslo účtu:</strong> {{ $transaction->bankAccount->account_number }}/1100</p>
            <p><strong>Částka:</strong> {{ number_format($transaction->amount, 2, ',', ' ') }} {{ $transaction->currency->value }}</p>
            <p><strong>Typ:</strong> {{ $transaction->transaction_type->label() }}</p>
            <p><strong>Stav:</strong> {{ $transaction->status->label() }}</p>
            <p><strong>Zpráva:</strong> {{ $transaction->message ?: '-' }}</p>
            <p><strong>Vytvořeno:</strong> {{ $transaction->created_at->format('d.m.Y H:i') }}</p>

            <div class="mt-4 d-flex gap-2 flex-wrap">
                @if($transaction->status !== \App\Domain\Enums\TransactionStatus::BLOCKED)
                    <form method="POST" action="{{ route('admin.transactions.block', $transaction) }}">
                        @csrf
                        <button class="btn btn-warning" onclick="return confirm('Zablokovat transakci?')">Blokovat</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.transactions.unblock', $transaction) }}">
                        @csrf
                        <button class="btn btn-success">Odblokovat</button>
                    </form>
                @endif

                @if($transaction->status !== \App\Domain\Enums\TransactionStatus::CANCELLED)
                    <form method="POST" action="{{ route('admin.transactions.cancel', $transaction) }}">
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Opravdu chcete transakci stornovat?')">Stornovat</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Zpět na přehled</a>
</div>
@endsection
