<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Admin CSS --}}
    <link href="{{ asset('admin/css/admin.css') }}" rel="stylesheet">
</head>
<body>

<div class="layout-wrapper d-flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main">

        {{-- NAVBAR --}}

        @include('admin.partials.navbar')

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        @include('admin.partials.footer')
    </div>
</div>

<script src="{{ asset('admin/js/admin.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css"></script>

@stack('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
    
</script>

</body>
</html>
