<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | Tracer Study</title>

    {{-- Bootstrap --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- CSS Admin --}}
    <link rel="stylesheet" href="{{ asset('admin/css/auth.css') }}">
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
                <h2>Admin Tracer Study</h2>
                <p class="subtitle">
                    Silakan login untuk melanjutkan
                </p>
    
                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/admin/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   required
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   required>
                        </div>

                        <button type="submit">
                            Login
                        </button>
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
