@extends('layout')

@section('title', 'Správa úvěrů')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Správa úvěrů</h3>

    {{-- Filtrovací formulář --}}
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="user" class="form-control" placeholder="Hledat uživatele..." value="{{ request('user') }}">
        </div>
        <div class="col-md-3">
            <select name="approved" class="form-select">
                <option value="">Všechny</option>
                <option value="1" @selected(request('approved')==='1')>Schválené</option>
                <option value="0" @selected(request('approved')==='0')>Čekající</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filtrovat</button>
        </div>
    </form>

    @if($loans->isEmpty())
        <div class="alert alert-info">Žádné úvěry k zobrazení.</div>
    @else
        {{-- Desktop tabulka --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Uživatel</th>
                        <th>Úrok (%)</th>
                        <th>Částka</th>
                        <th>Měsíční splátka</th>
                        <th>Schváleno</th>
                        <th>Vytvořeno</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->user->name }} {{ $loan->user->surname }}</td>
                            <td>{{ $loan->interest_rate }}</td>
                            <td>{{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</td>
                            <td>{{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč</td>
                            <td>
                                @if($loan->approved)
                                    <span class="badge bg-success">Ano</span>
                                @else
                                    <span class="badge bg-warning text-dark">Čeká</span>
                                @endif
                            </td>
                            <td>{{ $loan->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                @if(!$loan->approved)
                                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Schválit</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="d-inline-block ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu odstranit úvěr?')">
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
            @foreach ($loans as $loan)
                <div class="card mb-3 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">#{{ $loan->id }}</span>
                            <span class="badge {{ $loan->approved ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $loan->approved ? 'Schváleno' : 'Čeká' }}
                            </span>
                        </div>

                        <p class="mb-1"><strong>Uživatel:</strong> {{ $loan->user->name }} {{ $loan->user->surname }}</p>
                        <p class="mb-1"><strong>Úrok:</strong> {{ $loan->interest_rate }} %</p>
                        <p class="mb-1"><strong>Měsíční splátka:</strong> {{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč</p>
                        <p class="mb-1"><strong>Celková částka:</strong> {{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</p>
                        <p class="mb-2"><strong>Vytvořeno:</strong> {{ $loan->created_at->format('d.m.Y H:i') }}</p>

                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-outline-secondary flex-fill">Detail</a>

                            @if(!$loan->approved)
                                <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success w-100">Schválit</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Opravdu odstranit úvěr?')">
                                    Smazat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $loans->links() }}
        </div>
    @endif
</div>
@endsection
