@extends('presentation::layout')

@section('title', 'Správa karet')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Správa platebních karet</h3>

    {{-- Filtr --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="client" class="form-control" placeholder="Klient" value="{{ request('client') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="account" class="form-control" placeholder="Číslo účtu" value="{{ request('account') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Stav --</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktivní</option>
                <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Zablokovaná</option>
            </select>
        </div>
        <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-primary">Filtrovat</button>
        </div>
    </form>

    {{-- Desktop --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Klient</th>
                    <th>Účet</th>
                    <th>Číslo karty</th>
                    <th>Platnost</th>
                    <th>Stav</th>
                    <th class="text-end">Akce</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cards as $card)
                    <tr>
                        <td>{{ $card->id }}</td>
                        <td>{{ $card->bankAccount->user->full_name ?? '-' }}</td>
                        <td>{{ $card->bankAccount->account_number ?? '-' }}/1100</td>
                        <td>•••• •••• •••• {{ \Illuminate\Support\Str::substr($card->card_number, -4) }}</td>
                        <td>{{ $card->expire_month }}/{{ $card->expire_year }}</td>
                        <td>
                            <span class="badge {{ $card->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $card->is_active ? 'Aktivní' : 'Zablokovaná' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.cards.show', $card) }}" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Žádné karty</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobilní zobrazení --}}
    <div class="d-block d-md-none">
        @forelse($cards as $card)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">•••• {{ \Illuminate\Support\Str::substr($card->card_number, -4) }}</h5>
                    <p class="mb-1"><strong>Klient:</strong> {{ $card->bankAccount->user->full_name ?? '-' }}</p>
                    <p class="mb-1"><strong>Účet:</strong> {{ $card->bankAccount->account_number ?? '-' }}/1100</p>
                    <p class="mb-1"><strong>Platnost:</strong> {{ $card->expire_month }}/{{ $card->expire_year }}</p>
                    <p class="mb-1"><strong>Stav:</strong>
                        <span class="badge {{ $card->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $card->is_active ? 'Aktivní' : 'Zablokovaná' }}
                        </span>
                    </p>
                    <a href="{{ route('admin.cards.show', $card) }}" class="btn btn-sm btn-outline-primary w-100">Detail</a>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Žádné karty</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $cards->withQueryString()->links() }}
    </div>
</div>
@endsection
