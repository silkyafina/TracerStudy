<div class="topbar d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">
        <button id="sidebarToggle" class="toggle-btn">
            <i class="bi bi-list"></i>
        </button>

        <h6 class="mb-0 fw-semibold">
            @yield('page-title', 'Sistem Informasi Tracer Study')
        </h6>
    </div>

    {{-- 🔥 DROPDOWN PROFILE --}}
    <div class="dropdown">

        <button class="btn d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
            
            {{-- AVATAR --}}
            <div class="rounded-circle d-flex justify-content-center align-items-center text-white"
                style="width:35px;height:35px;background:#5a0f1b;">
                <i class="bi bi-person-fill"></i>
            </div>

            {{-- NAMA --}}
            <div class="text-start d-none d-md-block">
                <div class="fw-semibold">
                    {{ auth()->guard('admin')->user()->name }}
                </div>
                <small class="text-muted text-capitalize">
                    {{ str_replace('_',' ', auth()->guard('admin')->user()->role) }}
                </small>
            </div>

            <i class="bi bi-chevron-down small"></i>
        </button>

        {{-- 🔽 DROPDOWN MENU --}}
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">

            <li class="px-3 py-2">
                <div class="fw-semibold">
                    {{ auth()->guard('admin')->user()->name }}
                </div>
                <small class="text-muted text-capitalize">
                    {{ str_replace('_',' ', auth()->guard('admin')->user()->role) }}
                </small>
            </li>

            <li><hr class="dropdown-divider"></li>

            {{-- LOGOUT --}}
            <li>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item d-flex align-items-center gap-2 text-maroon">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>

        </ul>
    </div>

</div>