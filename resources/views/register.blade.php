<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
</head>
<body>
    <h2>Registrasi Pengguna</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ url('/register') }}" method="POST">
        @csrf

        <p>
            <label>Nama:</label><br>
            <input type="text" name="name" required>
        </p>

        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </p>

        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </p>

        <p>
            <label>Konfirmasi Password:</label><br>
            <input type="password" name="password_confirmation" required>
        </p>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
