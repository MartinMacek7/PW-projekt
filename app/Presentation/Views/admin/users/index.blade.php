@extends('layout')

@section('title', 'Správa uživatelů')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Správa uživatelů</h3>

    {{-- Filtrování --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
        </div>
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Jméno" value="{{ request('name') }}">
        </div>
        <div class="col-md-4">
            <input type="text" name="surname" class="form-control" placeholder="Příjmení" value="{{ request('surname') }}">
        </div>
        <div class="col-md-2 mt-2">
            <button class="btn btn-primary w-100">Filtrovat</button>
        </div>
    </form>

    @if($users->isEmpty())
        <div class="alert alert-info">Žádní uživatelé k zobrazení.</div>
    @else
        {{-- Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Role</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                        @foreach(\App\Domain\Enums\UserRole::cases() as $role)
                                            <option value="{{ $role->value }}" @selected($user->permission_level == $role->value)>
                                                {{ $role->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Opravdu smazat tohoto uživatele?')">Smazat</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobil stacked cards --}}
        <div class="d-block d-md-none">
            @foreach($users as $user)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="mb-1"><strong>Jméno:</strong> {{ $user->name }}</p>
                        <p class="mb-1"><strong>Příjmení:</strong> {{ $user->surname }}</p>
                        <p class="mb-0"><strong>Role:</strong>
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="mb-2">
                                @csrf
                                <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach(\App\Domain\Enums\UserRole::cases() as $role)
                                        <option value="{{ $role->value }}" @selected($user->permission_level == $role->value)>
                                            {{ $role->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Opravdu smazat tohoto uživatele?')">Smazat</button>
                            </form>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
