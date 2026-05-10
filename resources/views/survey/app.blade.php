<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Tracer Study | Universitas Harkat Negeri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background-color: #5a0f1b;
            padding: 15px 0;
        }

        .navbar-custom .navbar-brand {
            color: #ffffff;
            font-weight: 600;
            font-size: 18px;
        }

        .page-title {
            font-weight: 600;
            color: #343a40;
        }

        .card {
            border: 0;
            border-radius: 8px;
        }

        .card-header {
            background-color: #5a0f1b;
            color: #ffffff;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #5a0f1b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #741726;
        }
        .footer-custom {
            background-color: #5a0f1b;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
        }
        .form-check-input:checked {
            background-color: #7a0c18;
            border-color: #7a0c18;
        }

        .form-check-input {
            accent-color: #7a0c18;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-custom">
        <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
    
            {{-- KIRI (Logo) --}}
            <div class="d-flex align-items-center">
    
            <img src="{{ asset('images/logo-univ.png') }}"
                 alt="Logo UHN"
                 style="height:50px;"
                 class="me-3">
    
            <div class="text-white">
                <div style="font-weight:600; font-size:18px;">
                    SISTEM TRACER STUDY
                </div>
                <small>Universitas Harkat Negeri</small>
            </div>
    
        </div>
    </nav>

    <main class="flex-fill">
        <div class="container py-5">
            @yield('content')
        </div>
    </main>

    <footer class="footer-custom">
        © {{ date('Y') }} Tracer Study Universitas Harkat Negeri. All Rights Reserved.
    </footer>

</body>
</html>