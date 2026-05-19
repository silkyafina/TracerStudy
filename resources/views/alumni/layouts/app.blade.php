<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Tracer Study</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('alumni/css/alumni.css') }}">
</head>
<body>
    <!-- NAVBAR DASHBOARD -->
    <nav class="navbar navbar-expand-lg navbar-dashboard fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('alumni.dashboard') }}">
                <img src="{{ asset('images/logo-univ.png') }}" class="logo-small">
                <div>
                    <div class="brand-title-small">Tracer Study</div>
                    <div class="brand-subtitle-small">Dashboard Alumni</div>
                </div>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navDashboard">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navDashboard">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link-dashboard {{ Request::routeIs('alumni.dashboard') ? 'active' : '' }}" href="{{ route('alumni.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-dashboard {{ Request::routeIs('alumni.tracer.create') ? 'active' : '' }}" href="{{ route('alumni.tracer.section1') }}">
                            <i class="bi bi-clipboard-check me-1"></i> Isi Tracer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-dashboard {{ Request::routeIs('alumni.tracer.history') ? 'active' : '' }}" href="{{ route('alumni.tracer.riwayat') }}">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link-dashboard dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->alumni->nama_lengkap ?? 'Alumni' }}
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('alumni.profil') }}">
                                <i class="bi bi-person me-2"></i>Profil Saya
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('alumni.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-section">
        <div class="container">
     
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Tracer Study Universitas Harkat Negeri. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('select').select2({
                width: '100%'
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>