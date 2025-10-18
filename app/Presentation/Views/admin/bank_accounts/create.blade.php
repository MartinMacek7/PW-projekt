@extends('client.layout')

@section('title', 'Vytvořit bankovní účet')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Vytvořit bankovní účet</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bank_accounts.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Uživatel</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Měna</label>
            <select name="currency" class="form-select" required>
                @foreach($currencies as $currency)
                    <option value="{{ $currency->value }}">{{ $currency->value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Typ účtu</label>
            <select name="account_type" class="form-select" required>
                @foreach($accountTypes as $type)
                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                @endforeach
            </select>
        </div>


        <button class="btn btn-primary">Vytvořit účet</button>
    </form>
</div>
@endsection
