@extends('client.layout')

@section('title', 'Domů')

@section('content')


<div class="container my-5">

    <h1 class="dashboard-title">Vítejte, {{ Auth::user()->full_name }}!</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-user"></i>
                <h4>Profil</h4>
                <p>Prohlédnout a upravit osobní údaje</p>
                <a href="{{ route('profile') }}" class="btn btn-custom">Profil</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-wallet"></i>
                <h4>Účty</h4>
                <p>Zobrazit seznam účtů a zůstatků</p>
                <a href="{{ route('accounts') }}" class="btn btn-custom">Účty</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                <h4>Transakce</h4>
                <p>Zadat platbu a zobrazit historii</p>
                <a href="{{ route('transactions') }}" class="btn btn-custom">Transakce</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-credit-card"></i>
                <h4>Karty</h4>
                <p>Správa platebních karet</p>
                <a href="{{ route('cards') }}" class="btn btn-custom">Karty</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-repeat"></i>
                <h4>Trvalé příkazy</h4>
                <p>Založení a správa opakovaných plateb</p>
                <a href="{{ route('standing_orders') }}" class="btn btn-custom">Trvalé příkazy</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <h4>Úvěry</h4>
                <p>Žádost a přehled úvěrů</p>
                <a href="{{ route('loans') }}" class="btn btn-custom">Úvěry</a>
            </div>
        </div>
    </div>
</div>

@endsection
