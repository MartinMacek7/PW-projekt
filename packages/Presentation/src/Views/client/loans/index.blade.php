@extends('presentation::layout')

@section('title', 'Moje úvěry')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Moje úvěry</h3>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">Zažádat o úvěr</a>
    </div>

    @if($loans->isEmpty())
        <div class="alert alert-info">Nemáte žádné aktivní úvěry.</div>
    @else
        {{-- Desktop verze --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle" style="border: 1px solid rgb(90, 90, 90);">
                <thead class="table-light">
                    <tr>
                        <th>Úrok (%)</th>
                        <th>Měsíční splátka</th>
                        <th>Zbývá splatit</th>
                        <th>Celkový dluh</th>
                        <th>Schváleno</th>
                        <th>Vytvořeno</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loan->interest_rate }}</td>
                            <td>{{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč</td>
                            <td>{{ $loan->getFormattedBalance() }}</td>
                            <td>{{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</td>
                            <td>
                                @if($loan->approved)
                                    <span class="badge bg-success">Ano</span>
                                @else
                                    <span class="badge bg-warning text-dark">Čeká</span>
                                @endif
                            </td>
                            <td>{{ $loan->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                @if(!$loan->approved)
                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline-block ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Opravdu chcete zrušit tuto žádost?')">Zrušit</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobilní verze --}}
        <div class="d-block d-md-none">
            @foreach ($loans as $loan)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-2">
                            {{ number_format($loan->monthly_payment, 2, '.', ' ') }} Kč / měsíc
                        </h5>
                        <p><strong>Úrok:</strong> {{ $loan->interest_rate }} %</p>
                        <p><strong>Zbývá splatit:</strong> {{ $loan->getFormattedBalance() }}</p>
                        <p><strong>Celkem:</strong> {{ number_format($loan->total_balance, 2, '.', ' ') }} Kč</p>
                        <p><strong>Vytvořeno:</strong> {{ $loan->created_at->format('d.m.Y') }}</p>
                        <p><strong>Schváleno:</strong>
                            @if($loan->approved)
                                <span class="badge bg-success">Ano</span>
                            @else
                                <span class="badge bg-warning text-dark">Čeká</span>
                            @endif
                        </p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-primary flex-fill">Detail</a>
                            @if(!$loan->approved)
                                <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                        onclick="return confirm('Opravdu chcete zrušit tuto žádost?')">
                                        Zrušit
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
