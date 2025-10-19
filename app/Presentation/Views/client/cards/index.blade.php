@extends('layout')

@section('title', 'Moje karty')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Platební karty</h3>
    </div>

    @if($cards->isEmpty())
        <div class="alert alert-info">Nemáte žádné karty.</div>
    @else
        {{--  Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Účet</th>
                        <th>Číslo karty</th>
                        <th>Platnost</th>
                        <th>Stav</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cards as $card)
                        <tr>
                            <td>{{ $card->id }}</td>
                            <td>
                                @if($card->bankAccount)
                                    {{ $card->bankAccount->account_number }}/1100
                                @endif
                            </td>
                            <td>•••• •••• •••• {{ \Illuminate\Support\Str::substr($card->card_number, -4) }}</td>
                            <td>{{ $card->expire_month }}/{{ $card->expire_year }}</td>
                            <td>
                                @if($card->is_active)
                                    <span class="badge bg-success">Aktivní</span>
                                @else
                                    <span class="badge bg-danger">Zablokovaná</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('cards.show', $card) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <form action="{{ route('cards.toggle', $card) }}" method="POST" class="d-inline-block ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $card->is_active ? 'btn-danger' : 'btn-success' }}">
                                        {{ $card->is_active ? 'Zablokovat' : 'Odblokovat' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{--  Mobile verze --}}
        <div class="d-block d-md-none">
            <div class="row">

                @foreach($cards as $card)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">•••• {{ \Illuminate\Support\Str::substr($card->card_number, -4) }}</h5>
                                <p class="card-text mb-1">
                                    <strong>Účet:</strong> {{ $card->bankAccount?->account_number }}/1100
                                </p>
                                <p class="card-text mb-1">
                                    <strong>Platnost:</strong> {{ $card->expire_month }}/{{ $card->expire_year }}
                                </p>
                                <p class="card-text mb-2">
                                    <strong>Stav:</strong>
                                    @if($card->is_active)
                                        <span class="badge bg-success">Aktivní</span>
                                    @else
                                        <span class="badge bg-danger">Zablokovaná</span>
                                    @endif
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('cards.show', $card) }}" class="btn btn-sm btn-outline-primary flex-fill">Detail</a>
                                    <form action="{{ route('cards.toggle', $card) }}" method="POST" class="flex-fill">
                                        @csrf
                                        <button type="submit" class="btn btn-sm w-100 {{ $card->is_active ? 'btn-danger' : 'btn-success' }}">
                                            {{ $card->is_active ? 'Zablokovat' : 'Odblokovat' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
</div>
@endsection
