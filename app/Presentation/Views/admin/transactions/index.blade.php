@extends('client.layout')

@section('title', 'Správa transakcí')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Správa transakcí</h3>

    {{-- Filtr --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="client" class="form-control" placeholder="Klient" value="{{ request('client') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="account_number" class="form-control" placeholder="Číslo účtu" value="{{ request('account_number') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">-- Stav --</option>
                @foreach(\App\Domain\Enums\TransactionStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="transaction_type" class="form-select">
                <option value="">-- Typ --</option>
                @foreach(\App\Domain\Enums\TransactionType::cases() as $type)
                    <option value="{{ $type->value }}" {{ request('transaction_type') == $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="amount_min" class="form-control" placeholder="Od" value="{{ request('amount_min') }}">
        </div>
        <div class="col-md-1">
            <input type="number" name="amount_max" class="form-control" placeholder="Do" value="{{ request('amount_max') }}">
        </div>
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-primary">Filtrovat</button>
        </div>
    </form>

    {{-- Desktop tabulka --}}
    <div class="table-responsive shadow-sm d-none d-md-block">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Klient</th>
                    <th>Účet</th>
                    <th>Částka</th>
                    <th>Měna</th>
                    <th>Typ</th>
                    <th>Stav</th>
                    <th>Datum</th>
                    <th class="text-end">Akce</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->bankAccount->user->full_name }}</td>
                        <td>{{ $t->bankAccount->account_number }}</td>
                        <td>{{ number_format($t->amount, 2, ',', ' ') }}</td>
                        <td>{{ $t->currency->value }}</td>
                        <td>{{ $t->transaction_type->label() }}</td>
                        <td>{{ $t->status->label() }}</td>
                        <td>{{ $t->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.transactions.show', $t) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted">Žádné transakce</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile stacked cards --}}
    <div class="d-md-none">
        @forelse($transactions as $transaction)
            @php
                $type = $transaction->transaction_type;
                $isCredit = in_array($type, [
                    \App\Domain\Enums\TransactionType::DEPOSIT,
                    \App\Domain\Enums\TransactionType::INCOMING,
                    \App\Domain\Enums\TransactionType::INTEREST,
                ]);
                $status = $transaction->status;
            @endphp
            <div class="card mb-3 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">{{ $transaction->created_at->format('d.m.Y H:i') }}</span>
                        <span class="badge {{ match($status) {
                            \App\Domain\Enums\TransactionStatus::COMPLETED => 'bg-success',
                            \App\Domain\Enums\TransactionStatus::PENDING => 'bg-warning text-dark',
                            \App\Domain\Enums\TransactionStatus::FAILED => 'bg-danger',
                            \App\Domain\Enums\TransactionStatus::CANCELLED => 'bg-secondary',
                            \App\Domain\Enums\TransactionStatus::BLOCKED => 'bg-dark',
                            default => 'bg-light text-dark'
                        } }}">{{ $status->label() }}</span>
                    </div>

                    <p class="mb-1">
                        <strong>Typ:</strong>
                        <span class="{{ $isCredit ? 'text-success' : 'text-danger' }}">
                            <i class="fa-solid {{ $isCredit ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ $type->label() }}
                        </span>
                    </p>

                    <p class="mb-1"><strong>Klient:</strong> {{ $transaction->bankAccount->user->full_name }}</p>
                    <p class="mb-1"><strong>Účet:</strong> {{ $transaction->bankAccount->account_number }}/{{ $transaction->bankAccount->bank_code }}</p>
                    <p class="mb-1"><strong>Protiúčet:</strong> {{ $transaction->counterparty_account_number }}
                        @if($transaction->counterparty_bank_code)/{{ $transaction->counterparty_bank_code }}@endif
                    </p>

                    <p class="mb-1">
                        <strong>Částka:</strong>
                        <span class="{{ $isCredit ? 'text-success' : 'text-danger' }}">
                            {{ number_format($transaction->amount, 2, '.', ' ') }} {{ $transaction->currency->value }}
                        </span>
                    </p>

                    <p class="mb-2"><strong>Zpráva:</strong> {{ $transaction->message ?? '-' }}</p>

                    <div class="d-grid">
                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Žádné transakce</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $transactions->withQueryString()->links() }}
    </div>
</div>
@endsection
