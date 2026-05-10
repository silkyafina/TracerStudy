@extends('alumni.layouts.app')
@section('title', 'Dashboard Alumni')

@section('content')
<div class="container">

    {{-- WELCOME --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom p-4">
                <h3>Selamat Datang, {{ $alumni->nama_lengkap }}</h3>
                <p class="text-muted mb-0">
                    Dashboard Tracer Study Alumni
                </p>
            </div>
        </div>
    </div>

    {{-- PROGRESS --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="bi bi-graph-up me-2"></i>
                    Progress Tracer Study
                </div>
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-2">
                        <strong>Status</strong>
                        <span>
                            @if($status === 'submitted')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($session)
                                <span class="badge bg-warning">Dalam Proses</span>
                            @else
                                <span class="badge bg-secondary">Belum Mulai</span>
                            @endif
                        </span>
                    </div>

                    <div class="progress mb-3">
                        <div class="progress-bar bg-maroon"
                             style="width: {{ $progress }}%">
                            {{ $progress }}%
                        </div>
                    </div>

                    {{-- ACTION BUTTON --}}
                    @if(!$session)
                        <a href="{{ route('alumni.tracer.section1') }}"
                           class="btn btn-maroon">
                            <i class="bi bi-play-fill"></i>
                            Mulai Tracer Study
                        </a>

                    @elseif($status === 'draft')
                        <a href="{{ route('alumni.tracer.section' . $currentSection) }}"
                           class="btn btn-warning">
                            <i class="bi bi-arrow-repeat"></i>
                            Lanjutkan Pengisian (Section {{ $currentSection }})
                        </a>

                    @else
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Tracer Study telah selesai. Terima kasih!
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- STAT --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="bi bi-list-check"></i>
                </div>
                <div class="stat-value">{{ $totalSection }}</div>
                <div class="stat-label">Total Section</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">
                    {{ $status === 'submitted' ? 0 : $totalSection - ($currentSection - 1) }}
                </div>
                <div class="stat-label">Sisa Section</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value">{{ $progress }}%</div>
                <div class="stat-label">Progress</div>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS --}}
    <div class="row">
        <div class="col-12">
            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="bi bi-activity me-2"></i>
                    Aktivitas Terakhir
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $act)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($act['tanggal'])->format('d M Y H:i') }}</td>
                                    <td>{{ $act['aktivitas'] }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $act['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
