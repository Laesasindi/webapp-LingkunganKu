
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | LingkunganKu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-page">
    <main class="login-card">
        <a class="brand" href="{{ route('beranda') }}">
            <span class="brand-mark">L</span>
            <span>Lingkungan<span class="brand-green">Ku</span></span>
        </a>

        <div class="login-heading">
            <span class="eyebrow">ADMINISTRATOR</span>
            <h1>Selamat datang</h1>
            <p>Masuk untuk mengelola laporan warga LingkunganKu.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <label for="email">Email admin</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="admin@lingkunganku.local"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            >

            <button class="btn-primary" type="submit">
                Masuk ke Dashboard
            </button>
        </form>

        <a class="back-link" href="{{ route('beranda') }}">
            ← Kembali ke website LingkunganKu
        </a>

        <p class="login-footer">
            LingkunganKu &copy; {{ date('Y') }}
        </p>
    </main>
</body>
</html>
