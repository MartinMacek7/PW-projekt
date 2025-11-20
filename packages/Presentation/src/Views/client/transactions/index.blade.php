@extends('presentation::layout')

@section('title', 'Transakce')


@section('content')

<div class="container my-8">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mt-5 mb-0">Moje transakce</h3>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary mt-5">
            Zadání nové platby
        </a>
    </div>

    @include('presentation::client.components.transaction-table', [
        'transactions' => $transactions
    ])
</div>
@endsection
