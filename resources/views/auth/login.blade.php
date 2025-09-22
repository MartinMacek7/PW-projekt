<!DOCTYPE html>
<html>
<head>
    <title>Přihlášení</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Přihlášení</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Heslo:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Přihlásit se</button>
        </div>
    </form>
</body>
</html>
