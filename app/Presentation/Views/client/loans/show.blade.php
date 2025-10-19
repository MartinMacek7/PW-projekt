@extends('layout')

@section('title', 'Detail úvěru')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Detail úvěru</h3>

    <div class="card p-4 shadow-sm">
        <p><strong>Úroková sazba:</strong> {{ $loan->interest_rate }} %</p>
        <p><strong>Měsíční splátka:</strong> {{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč</p>
        <p><strong>Zbývá splatit:</strong> {{ $loan->getFormattedBalance() }}</p>
        <p><strong>Celkový dluh:</strong> {{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</p>
        <p><strong>Vytvořeno:</strong> {{ $loan->created_at->format('d.m.Y H:i') }}</p>

        <a href="{{ route('loans') }}" class="btn btn-secondary mt-3" style="width: 200px">Zpět na přehled</a>
    </div>
</div>
@endsection
