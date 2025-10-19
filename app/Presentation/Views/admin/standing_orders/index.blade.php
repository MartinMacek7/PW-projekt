@extends('layout')

@section('title', 'Trvalé příkazy')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Přehled trvalých příkazů</h3>

    {{-- Filtr --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="client_name" class="form-control" placeholder="Jméno klienta" value="{{ request('client_name') }}">
        </div>
        <div class="col-md-4">
            <input type="text" name="account_number" class="form-control" placeholder="Číslo účtu" value="{{ request('account_number') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Hledat</button>
        </div>
    </form>

    @if($orders->isEmpty())
        <div class="alert alert-info">Žádné trvalé příkazy nebyly nalezeny.</div>
    @else
        {{-- Desktop tabulka --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Klient</th>
                        <th>Účet</th>
                        <th>Protiúčet</th>
                        <th>Částka</th>
                        <th>Frekvence</th>
                        <th>Vytvořeno</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->bankAccount->user->surname }} {{ $order->bankAccount->user->name }}</td>
                            <td>{{ $order->bankAccount->account_number }}/1100</td>
                            <td>{{ $order->counterpart_account_number }}/{{ $order->counterpart_bank_code }}</td>
                            <td>{{ number_format($order->amount, 2, '.', ' ') }} {{ $order->currency }}</td>
                            <td>{{ $order->frequency->label() }}</td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.standing_orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <form action="{{ route('admin.standing_orders.destroy', $order) }}" method="POST" class="d-inline-block ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu smazat tento trvalý příkaz?')">
                                        Smazat
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile stacked cards --}}
        <div class="d-block d-md-none">
            @foreach ($orders as $order)
                <div class="card mb-3 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">#{{ $order->id }}</span>
                            <small class="text-muted">{{ $order->created_at->format('d.m.Y') }}</small>
                        </div>

                        <p class="mb-1"><strong>Klient:</strong> {{ $order->bankAccount->user->surname }} {{ $order->bankAccount->user->name }}</p>
                        <p class="mb-1"><strong>Účet:</strong> {{ $order->bankAccount->account_number }}/1100</p>
                        <p class="mb-1"><strong>Protiúčet:</strong> {{ $order->counterpart_account_number }}/{{ $order->counterpart_bank_code }}</p>
                        <p class="mb-1"><strong>Částka:</strong> {{ number_format($order->amount, 2, '.', ' ') }} {{ $order->currency }}</p>
                        <p class="mb-2"><strong>Frekvence:</strong> {{ $order->frequency->label() }}</p>

                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('admin.standing_orders.show', $order) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                Detail
                            </a>
                            <form action="{{ route('admin.standing_orders.destroy', $order) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Opravdu smazat tento trvalý příkaz?')">
                                    Smazat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
