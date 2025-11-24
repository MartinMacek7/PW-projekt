<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }

        .balance {
            font-size: 16px;
            font-weight: bold;
        }
    </style>

</head>
<body>

<h2>Výpis z bankovního účtu</h2>

<p><strong>Účet:</strong> {{ $account->account_number }}/1100</p>
<p><strong>Majitel:</strong> {{ $account->user->full_name }}</p>
<p><strong>Měna:</strong> {{ $account->currency->value }}</p>
<p class="balance"><strong>Zůstatek:</strong> {{ $account->getFormattedBalance() }}</p>

<h3>Historie transakcí</h3>

<table>
    <thead>
    <tr>
        <th>Datum</th>
        <th>Typ</th>
        <th>Částka</th>
        <th>Protiúčet</th>
        <th>Zpráva</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $t)
        <tr>
            <td>{{ $t->created_at->format('d.m.Y H:i') }}</td>
            <td>{{ $t->transaction_type->label() }}</td>
            <td>{{ number_format($t->amount, 2, ',', ' ') }} {{ $t->currency->value }}</td>
            <td>{{ $t->counterparty_account_number }}/{{ $t->counterparty_bank_code }}</td>
            <td>{{ $t->message ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
