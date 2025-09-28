@extends('client.auth.layout')

@section('title', 'Přihlášení')

@section('content')

<section class="card login">
    <h1>Přihlášení</h1>
    <p>Zadejte své údaje pro přístup do bankovnictví</p>

    @if ($errors->any())
        <div class="form-errors">
            @foreach ($errors->all() as $error)
                <span class="form-error">{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login.post') }}">

        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="vas@domena.cz" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Heslo</label>
            <input id="password" name="password" type="password" placeholder="Zadejte heslo" required>
        </div>

        <button type="submit" class="btn">Přihlásit se</button>
    </form>

    <div class="alt">Nemáte účet? <a href="{{ route('register') }}">Zaregistrujte se</a></div>
</section>

@endsection

