<div class="sidebar" id="sidebar">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="brand">
        <i class="bi bi-mortarboard"></i>
        <span>TracerStudy</span>
    </div>

    <ul class="menu">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
            <a href="{{ route('admin.alumni.index') }}">
                <i class="bi bi-people"></i>
                <span>Data Alumni</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.tracer-section.*') ? 'active' : '' }}">
            <a href="{{ route('admin.tracer-section.index') }}">
                <i class="bi bi-ui-checks"></i>
                <span>Kuesioner Tracer Study</span>
            </a>
        </li>

            <li class="{{ request()->routeIs('admin.tracer.results.*') ? 'active' : '' }}">
                <a href="{{ route('admin.tracer.results.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Hasil Tracer Study</span>
                </a>
            </li>

        <li class="{{ request()->routeIs('admin.laporan.index*') ? 'active' : '' }}">
            <a href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan Tracer Study</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.user_survey_answers.index*') ? 'active' : '' }}">
            <a href="{{ route('admin.user_survey_answers.index') }}">
                <i class="bi bi-person-check"></i>
                <span>Penilaian Pengguna Lulusan</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.laporan.pengguna.index*') ? 'active' : '' }}">
            <a href="{{ route('admin.laporan.pengguna.index') }}">
                <i class="bi bi-pie-chart"></i>
                <span>Laporan Pengguna Lulusan</span>
            </a>
        </li>
    </ul>
</div>


