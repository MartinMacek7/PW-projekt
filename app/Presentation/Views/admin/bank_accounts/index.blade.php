@extends('client.layout')

@section('title', 'Správa bankovních účtů')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Správa bankovních účtů</h3>
        <a href="{{ route('admin.bank_accounts.create') }}" class="btn btn-primary">Vytvořit účet</a>
    </div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="account_number" value="{{ request('account_number') }}" class="form-control" placeholder="Číslo účtu">
        </div>
        <div class="col-md-3">
            <input type="text" name="user_name" value="{{ request('user_name') }}" class="form-control" placeholder="Jméno nebo příjmení">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrovat</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Majitel</th>
                    <th>Číslo účtu</th>
                    <th>Měna</th>
                    <th>Zůstatek</th>
                    <th class="text-end">Akce</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->user->full_name }}</td>
                    <td>{{ $account->account_number }}/1100</td>
                    <td>{{ $account->currency->value }}</td>
                    <td>{{ number_format($account->balance,2,'.',' ') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.bank_accounts.show', $account) }}" class="btn btn-sm btn-outline-primary">Detail</a>

                        <form action="{{ route('admin.bank_accounts.destroy', $account) }}" method="POST" class="d-inline-block ms-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu chcete zrušit účet?')">Zrušit</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $accounts->links() }}
    </div>
</div>
@endsection
