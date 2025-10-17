@extends('client.layout')

@section('title', 'Žádost o úvěr')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Žádost o úvěr</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Požadovaná částka úvěru (Kč)</label>
            <input type="number" step="0.01" name="requested_amount" class="form-control" value="{{ old('requested_amount') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Měsíční splátka (Kč)</label>
            <input type="number" step="0.01" name="monthly_payment" class="form-control" value="{{ old('monthly_payment') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Počet měsíců splácení</label>
            <input type="number" name="months" class="form-control" value="{{ old('months', 12) }}" required>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary px-4">Odeslat žádost</button>
        </div>
    </form>

</div>
@endsection
