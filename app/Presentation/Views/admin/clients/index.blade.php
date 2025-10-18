@extends('client.layout')

@section('title', 'Správa klientů')

@section('content')
<div class="container my-5">
    <h3>Správa klientů</h3>

    {{-- Filtr --}}
    <form method="GET" action="{{ route('admin.clients.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Jméno" value="{{ request('name') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{ request('email') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="phone_number" class="form-control" placeholder="Telefon" value="{{ request('phone_number') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="birth_number" class="form-control" placeholder="Rodné číslo" value="{{ request('birth_number') }}">
        </div>
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary">Filtrovat</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    @if($clients->isEmpty())
        <div class="alert alert-info">Žádní klienti nejsou registrováni.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Jméno</th>
                        <th>E-mail</th>
                        <th>Telefon</th>
                        <th>Rodné číslo</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->full_name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone_number }}</td>
                            <td>{{ $client->birth_number }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary">Upravit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Stránkování --}}
            {{ $clients->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
