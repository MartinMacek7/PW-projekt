<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Internetové bankovnictví</title>
</head>
<body>
    <h1>Vítejte, {{ Auth::user()->full_name }}!</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Odhlásit se</button>
    </form>

    {{ $promenna }}
</body>
</html>
