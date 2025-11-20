@props(['transactions'])

<style>
    .transaction-credit {
        color: #198754;
        font-weight: 500;
    }
    .transaction-debit {
        color: #dc3545;
        font-weight: 500;
    }
    .card-body p {
        font-size: 0.9rem;
    }
</style>

<div class="transaction-table-wrapper">

    {{-- Desktop table --}}
    <table class="table table-hover transaction-table d-none d-md-table">
        <thead class="table-light">
            <tr>
                <th class="text-nowrap">Datum</th>
                <th class="text-nowrap">Typ</th>
                <th class="text-nowrap">Účet</th>
                <th class="text-nowrap">Protiúčet</th>
                <th class="text-nowrap">Částka</th>
                <th>Zpráva</th>
                <th class="text-nowrap">Stav</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                @php
                    $type = $transaction->transaction_type;
                    $isCredit = in_array($type, [
                        \Domain\Enums\TransactionType::DEPOSIT,
                        \Domain\Enums\TransactionType::INCOMING,
                        \Domain\Enums\TransactionType::INTEREST,
                    ]);
                    $status = $transaction->status;
                @endphp

                <tr>
                    <td class="text-nowrap">{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                    <td class="text-nowrap">
                        <span class="{{ $isCredit ? 'transaction-credit' : 'transaction-debit' }}">
                            <i class="fa-solid {{ $isCredit ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ $type->label() }}
                        </span>
                    </td>
                    <td class="text-nowrap">{{ $transaction->bankAccount->account_number }}/1100</td>
                    <td class="text-nowrap">
                        {{ $transaction->counterparty_account_number }}/{{ $transaction->counterparty_bank_code }}
                    </td>
                    <td class="text-nowrap">
                        <strong class="{{ $isCredit ? 'transaction-credit' : 'transaction-debit' }}">
                            {{ number_format($transaction->amount, 2, '.', ' ') }} {{ $transaction->currency->value }}
                        </strong>
                    </td>
                    <td>{{ $transaction->message ?? '-' }}</td>
                    <td class="text-nowrap">
                        <span class="badge {{ match($status) {
                            \Domain\Enums\TransactionStatus::COMPLETED => 'bg-success',
                            \Domain\Enums\TransactionStatus::PENDING => 'bg-warning text-dark',
                            \Domain\Enums\TransactionStatus::FAILED => 'bg-danger',
                            \Domain\Enums\TransactionStatus::CANCELLED => 'bg-secondary',
                            \Domain\Enums\TransactionStatus::BLOCKED => 'bg-dark',
                            default => 'bg-light text-dark'
                        } }}">{{ $status->label() }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Žádné transakce</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Mobile stacked cards --}}
    <div class="d-md-none">
        @forelse($transactions as $transaction)
            @php
                $type = $transaction->transaction_type;
                $isCredit = in_array($type, [
                    \Domain\Enums\TransactionType::DEPOSIT,
                    \Domain\Enums\TransactionType::INCOMING,
                    \Domain\Enums\TransactionType::INTEREST,
                ]);
                $status = $transaction->status;
            @endphp
            <div class="card mb-3 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">{{ $transaction->created_at->format('d.m.Y H:i') }}</span>
                        <span class="badge {{ match($status) {
                            \Domain\Enums\TransactionStatus::COMPLETED => 'bg-success',
                            \Domain\Enums\TransactionStatus::PENDING => 'bg-warning text-dark',
                            \Domain\Enums\TransactionStatus::FAILED => 'bg-danger',
                            \Domain\Enums\TransactionStatus::CANCELLED => 'bg-secondary',
                            \Domain\Enums\TransactionStatus::BLOCKED => 'bg-dark',
                            default => 'bg-light text-dark'
                        } }}">{{ $status->label() }}</span>
                    </div>

                    <p class="mb-1">
                        <strong>Typ:</strong>
                        <span class="{{ $isCredit ? 'transaction-credit' : 'transaction-debit' }}">
                            <i class="fa-solid {{ $isCredit ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ $type->label() }}
                        </span>
                    </p>

                    <p class="mb-1"><strong>Účet:</strong> {{ $transaction->bankAccount->account_number }}/1100</p>
                    <p class="mb-1"><strong>Protiúčet:</strong> {{ $transaction->counterparty_account_number }}
                        @if($transaction->counterparty_bank_code)/{{ $transaction->counterparty_bank_code }}@endif
                    </p>

                    <p class="mb-1">
                        <strong>Částka:</strong>
                        <span class="{{ $isCredit ? 'transaction-credit' : 'transaction-debit' }}">
                            {{ number_format($transaction->amount, 2, '.', ' ') }} {{ $transaction->currency->value }}
                        </span>
                    </p>

                    <p class="mb-0"><strong>Zpráva:</strong> {{ $transaction->message ?? '-' }}</p>
                </div>
            </div>
        @empty
            <p class="text-center">Žádné transakce</p>
        @endforelse
    </div>
</div>
