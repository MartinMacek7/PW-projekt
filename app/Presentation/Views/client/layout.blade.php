<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'IB') | MojeBanka</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('css')

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{  route('homepage') }}">Moje Banka</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('accounts*') ? 'active' : '' }}" href="{{ route('accounts') }}">Účty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions*') ? 'active' : '' }}" href="{{ route('transactions') }}">Transakce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cards*') ? 'active' : '' }}" href="{{ route('cards') }}">Karty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('standing_orders*') ? 'active' : '' }}" href="{{ route('standing_orders') }}">Trvalé příkazy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('loans*') ? 'active' : '' }}" href="{{ route('loans') }}">Úvěry</a>
                    </li>

                    @if(auth()->user()->isBanker())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-danger"href="#" id="navbarBankDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pracovník banky
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarBankDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.clients.index') }}">Klienti</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.bank_accounts.index') }}">Správa bankovních účtů</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}">Správa transakcí</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.cards.index') }}">Správa karet</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.standing_orders.index') }}">Správa trvalých příkazů</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.loans.index') }}">Správa úvěrů</a></li>

                                @if(auth()->user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="{{ route('admin.users.index') }}">Správa uživatelů</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                </ul>

                <div class="d-flex">
                    <a class="btn btn-custom btn-logout" href="{{ route('logout') }}">Odhlásit se</a>
                </div>

            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <main>
        @yield('content')
    </main>

</body>
</html>
