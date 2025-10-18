@extends('client.layout')

@section('title', 'Detail trvalého příkazu')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Detail trvalého příkazu</h3>

    <div class="card p-4 shadow-sm">
        <p><strong>Klient:</strong> {{ $standingOrder->bankAccount->user->surname }} {{ $standingOrder->bankAccount->user->name }}</p>
        <p><strong>Účet:</strong> {{ $standingOrder->bankAccount->account_number }}/1100</p>
        <p><strong>Protiúčet:</strong> {{ $standingOrder->counterpart_account_number }}/{{ $standingOrder->counterpart_bank_code }}</p>
        <p><strong>Částka:</strong> {{ number_format($standingOrder->amount, 2) }} {{ $standingOrder->currency }}</p>
        <p><strong>Frekvence:</strong> {{ $standingOrder->frequency->label() }}</p>
        <p><strong>Období:</strong> {{ $standingOrder->start_date }} – {{ $standingOrder->end_date ?? 'neurčeno' }}</p>
        <p><strong>Vytvořeno:</strong> {{ $standingOrder->created_at->format('d.m.Y H:i') }}</p>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('admin.standing_orders.index') }}" class="btn btn-secondary">Zpět</a>
        <form action="{{ route('admin.standing_orders.destroy', $standingOrder) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu smazat tento příkaz?')">Smazat</button>
        </form>
    </div>
</div>
@endsection
