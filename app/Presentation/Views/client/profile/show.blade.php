@extends('layout')

@section('title', 'Profil')

@section('css')
<style>

    button.save {
        max-width: 250px;
        margin: 0 auto;
    }


</style>
@endsection

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Můj profil</h4>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="form-errors">
                            @foreach ($errors->all() as $error)
                                <span class="form-error">{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Jméno</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $user->name) }}">
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="surname" class="form-label">Příjmení</label>
                                <input type="text" name="surname" id="surname" class="form-control"
                                       value="{{ old('surname', $user->surname) }}">
                                @error('surname') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $user->email) }}">
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth_number" class="form-label">Rodné číslo</label>
                                <input type="text" name="birth_number" id="birth_number" class="form-control"
                                       value="{{ old('birth_number', $user->birth_number) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Telefon</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                       value="{{ old('phone_number', $user->phone_number) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Pohlaví</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="M" {{ old('gender', $user->gender) == 'M' ? 'selected' : '' }}>Muž</option>
                                <option value="F" {{ old('gender', $user->gender) == 'F' ? 'selected' : '' }}>Žena</option>
                            </select>
                        </div>

                        <hr>

                        <h5 class="mb-3">Adresa</h5>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="address_street" class="form-label">Ulice</label>
                                <input type="text" name="address_street" id="address_street" class="form-control"
                                       value="{{ old('address_street', $user->address_street) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address_number" class="form-label">Číslo domu</label>
                                <input type="text" name="address_number" id="address_number" class="form-control"
                                       value="{{ old('address_number', $user->address_number) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="address_city" class="form-label">Město</label>
                                <input type="text" name="address_city" id="address_city" class="form-control"
                                       value="{{ old('address_city', $user->address_city) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="address_zip_code" class="form-label">PSČ</label>
                                <input type="text" name="address_zip_code" id="address_zip_code" class="form-control"
                                       value="{{ old('address_zip_code', $user->address_zip_code) }}">
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Změna hesla</h5>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nové heslo</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Potvrzení hesla</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary save">Uložit změny</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
