@extends('client.layout')

@section('title', 'Trvalé příkazy')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Moje trvalé příkazy</h3>
        <a href="{{ route('standing_orders.create') }}" class="btn btn-primary">Nový příkaz</a>
    </div>

    @if($orders->isEmpty())
        <div class="alert alert-info">Nemáte žádné trvalé příkazy.</div>
    @else
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Účet</th>
                        <th>Protiúčet</th>
                        <th>Částka</th>
                        <th>Frekvence</th>
                        <th>Období</th>
                        <th class="text-end">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->bankAccount->account_number }}/1100</td>
                            <td>{{ $order->counterpart_account_number }}/{{ $order->counterpart_bank_code }}</td>
                            <td>{{ number_format($order->amount, 2) }} {{ $order->currency }}</td>
                            <td>{{ $order->frequency->label() }}</td>
                            <td>{{ $order->start_date }} – {{ $order->end_date ?? 'neurčeno' }}</td>
                            <td class="text-end">
                                <a href="{{ route('standing_orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <form action="{{ route('standing_orders.destroy', $order) }}" method="POST" class="d-inline-block ms-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu smazat trvalý příkaz?')">
                                        Smazat
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- mobilní verze --}}
        <div class="d-block d-md-none">
            @foreach($orders as $order)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($order->amount, 2) }} {{ $order->currency }}</h5>
                        <p><strong>Účet:</strong> {{ $order->bankAccount->account_number }}/1100</p>
                        <p><strong>Protiúčet:</strong> {{ $order->counterpart_account_number }}/{{ $order->counterpart_bank_code }}</p>
                        <p><strong>Frekvence:</strong> {{ $order->frequency->label() }}</p>
                        <p><strong>Období:</strong> {{ $order->start_date }} – {{ $order->end_date ?? 'neurčeno' }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('standing_orders.show', $order) }}" class="btn btn-sm btn-outline-primary flex-fill">Detail</a>

                                <form action="{{ route('standing_orders.destroy', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu smazat trvalý příkaz?')">
                                        Smazat
                                    </button>
                                </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
