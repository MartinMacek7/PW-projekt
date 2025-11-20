@extends('presentation::layout')

@section('title', 'Účty')

@section('css')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-account {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card-account:hover {
            transform: translateY(-5px);
        }
        .card-title i {
            color: #0d6efd;
        }
        .balance {
            font-size: 1.5rem;
            font-weight: bold;
            color: #198754;
        }
    </style>
@endsection

@section('content')
<<div class="container my-5">
    <h1 class="text-center mb-5">Moje účty</h1>

    <div class="row justify-content-center">
        @forelse($accounts as $account)

            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card card-account w-100" style="max-width: 350px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3">

                            @if($account->account_type === \Domain\Enums\AccountType::CHECKING)
                                <i class="fa-solid fa-wallet me-2"></i>
                            @elseif($account->account_type === \Domain\Enums\AccountType::SAVINGS)
                                <i class="fa-solid fa-piggy-bank me-2"></i>
                            @endif

                            {{ $account->account_type->label() }}
                        </h5>

                        <p class="card-text mb-2"><strong>Číslo účtu:</strong> {{ $account->account_number }}/1100</p>
                        <p class="card-text mb-2"><strong>Měna:</strong> {{ $account->currency->value }}</p>
                        <p class="card-text mb-3"><strong>Zůstatek:</strong> <span class="balance">{{ $account->getFormattedBalance() }}</span></p>
                        <a href="{{ route('accounts.show', $account) }}" class="btn btn-primary px-4">Detail účtu</a>
                    </div>
                </div>
            </div>

        @empty
            <p class="text-center">Nemáte žádné účty.</p>
        @endforelse
    </div>

</div>
@endsection
