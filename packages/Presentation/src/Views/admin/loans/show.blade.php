@extends('presentation::layout')

@section('title', 'Detail úvěru')

@section('content')
<div class="container my-5" style="max-width: 700px;">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Úvěr #{{ $loan->id }}</h5>
            <a href="{{ route('admin.loans.index') }}" class="btn btn-sm btn-outline-secondary">Zpět</a>
        </div>
        <div class="card-body">
            <p><strong>Uživatel:</strong> {{ $loan->user->name }} {{ $loan->user->surname }} ({{ $loan->user->email }})</p>
            <p><strong>Úroková sazba:</strong> {{ $loan->interest_rate }} %</p>
            <p><strong>Měsíční splátka:</strong> {{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč</p>
            <p><strong>Zbývá splatit:</strong> {{ number_format($loan->remaining_balance, 2, '.', ' ') }} Kč</p>
            <p><strong>Celkový dluh:</strong> {{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</p>
            <p><strong>Schváleno:</strong>
                @if($loan->approved)
                    <span class="badge bg-success">Ano</span>
                @else
                    <span class="badge bg-warning text-dark">Čeká</span>
                @endif
            </p>
            <p><strong>Vytvořeno:</strong> {{ $loan->created_at->format('d.m.Y H:i') }}</p>

            <div class="mt-4 d-flex gap-2">
                @if(!$loan->approved)
                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST">
                        @csrf
                        <button class="btn btn-success">Schválit úvěr</button>
                    </form>
                @endif

                <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Opravdu odstranit úvěr?')">Smazat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
