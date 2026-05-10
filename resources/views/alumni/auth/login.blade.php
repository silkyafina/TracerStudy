<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Alumni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">
    <link rel="stylesheet" href="{{ asset('alumni/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="login-container">

    <!-- KIRI -->
    <div class="login-left">
        <img src="{{ asset('images/logo-alumni.png') }}" class="logo">
        <h2>Universitas Harkat Negeri</h2>
    </div>

    <!-- KANAN -->
    <div class="login-right">
        <div class="form-box">

            <h2>Tracer Study Alumni</h2>
            <p class="subtitle">
                Silakan login menggunakan data akademik Anda
            </p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('alumni.login.process') }}">
                @csrf

                <label>NIM</label>
                <input type="text"
                       name="nim"
                       value="{{ old('nim') }}"
                       placeholder="Masukkan NIM"
                       required>

                <label>Tanggal Lahir</label>
                <input type="date"
                       name="tanggal_lahir"
                       required>

                <button type="submit">Masuk</button>
                <p style="margin-top:10px;">
                    Belum punya akun?
                    <a href="{{ route('alumni.register') }}">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>

</div>

</body>
</html>
