@extends('client.auth.layout')

@section('title', 'Registrace')


@section('content')


<section class="card register">
    <h1>Registrace</h1>
    <p>Vyplňte formulář pro vytvoření účtu</p>

    @if ($errors->any())
        <div class="form-errors">
            @foreach ($errors->all() as $error)
                <span class="form-error">{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form id="regForm" method="POST" action="{{ route('register.post') }}">
        @csrf

        <div>
            <label for="name">Jméno</label>
            <input id="name" name="name" type="text" placeholder="Jan" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="surname">Příjmení</label>
            <input id="surname" name="surname" type="text" placeholder="Novák" value="{{ old('surname') }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="vas@domena.cz" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="birth_number">Rodné číslo</label>
            <input id="birth_number" name="birth_number" type="text" placeholder="123456/7890" value="{{ old('birth_number') }}" required>
        </div>

        <div>
            <label for="phone_number">Telefon</label>
            <input id="phone_number" name="phone_number" type="tel" placeholder="+420 123 456 789" value="{{ old('phone_number') }}" required>
        </div>

        <div>
            <label for="gender">Pohlaví</label>
            <select id="gender" name="gender" required>
                <option value="">- Zvolte pohlaví -</option>
                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Muž</option>
                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Žena</option>
            </select>
        </div>

        <div>
            <label for="password">Heslo</label>
            <input id="password" name="password" type="password" placeholder="Min. 8 znaků" required>
        </div>

        <div>
            <label for="password_confirmation">Potvrzení hesla</label>
            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Zadejte znovu" required>
        </div>

        <div>
            <label for="address_street">Ulice</label>
            <input id="address_street" name="address_street" type="text" placeholder="Hlavní" value="{{ old('address_street') }}" required>
        </div>

        <div>
            <label for="address_number">Číslo domu</label>
            <input id="address_number" name="address_number" type="text" placeholder="123" value="{{ old('address_number') }}" required>
        </div>

        <div>
            <label for="address_city">Město</label>
            <input id="address_city" name="address_city" type="text" placeholder="Praha" value="{{ old('address_city') }}" required>
        </div>

        <div>
            <label for="address_zip_code">PSČ</label>
            <input id="address_zip_code" name="address_zip_code" type="text" placeholder="11000" value="{{ old('address_zip_code') }}" required>
        </div>

        <button type="submit" class="btn">Zaregistrovat se</button>
    </form>

    <div class="alt">Máte již účet? <a href="{{  route('login') }}">Přihlaste se</a></div>
</section>

@endsection


