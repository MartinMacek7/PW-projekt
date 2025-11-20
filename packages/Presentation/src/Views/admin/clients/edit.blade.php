@extends('presentation::layout')

@section('title', 'Upravit klienta')

@section('content')
<div class="container my-5">
    <h3>Upravit klienta: {{ $client->full_name }}</h3>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Osobní údaje --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Jméno</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}">
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="surname" class="form-label">Příjmení</label>
                <input type="text" name="surname" class="form-control" value="{{ old('surname', $client->surname) }}">
                @error('surname') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="birth_number" class="form-label">Rodné číslo</label>
                <input type="text" name="birth_number" class="form-control" value="{{ old('birth_number', $client->birth_number) }}">
                @error('birth_number') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone_number" class="form-label">Telefon</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $client->phone_number) }}">
                @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Pohlaví</label>
            <select name="gender" class="form-select">
                <option value="M" {{ old('gender', $client->gender) == 'M' ? 'selected' : '' }}>Muž</option>
                <option value="F" {{ old('gender', $client->gender) == 'F' ? 'selected' : '' }}>Žena</option>
            </select>
        </div>

        <hr>

        {{-- Adresa --}}
        <h5>Adresa</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="address_street" class="form-label">Ulice</label>
                <input type="text" name="address_street" class="form-control" value="{{ old('address_street', $client->address_street) }}">
                @error('address_street') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-2 mb-3">
                <label for="address_number" class="form-label">Číslo domu</label>
                <input type="text" name="address_number" class="form-control" value="{{ old('address_number', $client->address_number) }}">
                @error('address_number') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="address_zip_code" class="form-label">PSČ</label>
                <input type="text" name="address_zip_code" class="form-control" value="{{ old('address_zip_code', $client->address_zip_code) }}">
                @error('address_zip_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="address_city" class="form-label">Město</label>
                <input type="text" name="address_city" class="form-control" value="{{ old('address_city', $client->address_city) }}">
                @error('address_city') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr>

        {{-- Heslo --}}
        <h5>Změna hesla</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Nové heslo</label>
                <input type="password" name="password" class="form-control">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">Potvrzení hesla</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-primary">Uložit změny</button>
        </div>
    </form>
</div>
@endsection
