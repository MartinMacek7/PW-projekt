@extends('layout')

@section('title', 'Detail karty')

@section('content')
<div class="container my-5" style="max-width: 720px;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail karty</h5>
            <div>
                <a href="{{ route('cards') }}" class="btn btn-sm btn-outline-secondary">Zpět na přehled</a>
            </div>
        </div>
        <div class="card-body">

            <dl class="row">
                <dt class="col-sm-4">ID</dt><dd class="col-sm-8">{{ $card->id }}</dd>
                <dt class="col-sm-4">Účet</dt>
                <dd class="col-sm-8">
                    @if($card->bankAccount)
                        {{ $card->bankAccount->account_number }}/1100
                    @endif
                </dd>

                <dt class="col-sm-4">Číslo karty</dt>
                <dd class="col-sm-8">•••• •••• •••• {{ \Illuminate\Support\Str::substr($card->card_number, -4) }}</dd>

                <dt class="col-sm-4">Platnost</dt>
                <dd class="col-sm-8">{{ $card->expire_month }}/{{ $card->expire_year }}</dd>

                <dt class="col-sm-4">Stav</dt>
                <dd class="col-sm-8">
                    @if($card->is_active)
                        <span class="badge bg-success">Aktivní</span>
                    @else
                        <span class="badge bg-danger">Zablokovaná</span>
                    @endif
                </dd>

                <dt class="col-sm-4">Vytvořeno</dt>
                <dd class="col-sm-8">{{ $card->created_at->format('j. n. Y H:i') }}</dd>
            </dl>

            <div class="mt-3">
                <form action="{{ route('cards.toggle', $card) }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn {{ $card->is_active ? 'btn-danger' : 'btn-success' }}">
                        {{ $card->is_active ? 'Zablokovat kartu' : 'Odblokovat kartu' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
