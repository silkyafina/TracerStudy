@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- FILTER --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <form method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label>Tahun Lulus Dari</label>

                    <select name="tahun_dari" class="form-control">
                        <option value="">-</option>

                        @foreach($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_dari') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tahun Lulus Sampai</label>

                    <select name="tahun_sampai" class="form-control">
                        <option value="">-</option>

                        @foreach($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_sampai') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Program Studi</label>

                    <select name="prodi_id" class="form-control">
                        <option value="">Semua</option>

                        @foreach($prodi as $p)
                            <option value="{{ $p->id }}"
                                {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-maroon w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h2 class="mb-2 fw-bold text-dark">Dashboard Administrator</h2>
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar3 me-2"></i>
                                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="text-end">
                           
                            <div>
                                <span class="badge bg-maroon px-3 py-2">
                                    Sistem Tracer Study
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK UTAMA --}}
    <div class="row mb-4">
        <!-- Total Alumni -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Alumni</p>
                            <h3 class="fw-bold mb-2">{{ number_format($totalAlumni) }}</h3>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-people-fill me-1"></i>
                                Alumni Terdaftar
                            </p>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Responden -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Responden</p>
                            <h3 class="fw-bold mb-2 text-success">{{ number_format($totalResponden) }}</h3>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Sudah Mengisi
                            </p>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Mengisi -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <p class="text-muted mb-2 text-uppercase small fw-semibold">Belum Mengisi</p>
                            <h3 class="fw-bold mb-2 text-warning">{{ number_format($totalAlumni - $totalResponden) }}</h3>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Alumni
                            </p>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-exclamation-circle fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tingkat Partisipasi -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <p class="text-muted mb-2 text-uppercase small fw-semibold">Tingkat Partisipasi</p>
                            <h3 class="fw-bold mb-2 text-info">
                                {{ $totalAlumni > 0 ? number_format(($totalResponden / $totalAlumni) * 100, 1) : 0 }}%
                            </h3>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-graph-up me-1"></i>
                                Response Rate
                            </p>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-bar-chart fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATUS PEKERJAAN ALUMNI --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-briefcase me-2 text-maroon"></i>
                        Status Pekerjaan Alumni
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Bekerja -->
                        <div class="col-lg-4 col-md-6 col-12 border-end">
                            <div class="p-4 text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width: 70px; height: 70px;">
                                        <i class="bi bi-briefcase-fill fs-2 text-success"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted mb-2 fw-semibold">Bekerja</h6>
                                <h2 class="fw-bold mb-2">{{ number_format($status['bekerja']) }}</h2>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $totalResponden > 0 ? ($status['bekerja'] / $totalResponden) * 100 : 0 }}%"></div>
                                </div>
                                <small class="text-success fw-semibold">
                                    {{ $totalResponden > 0 ? number_format(($status['bekerja'] / $totalResponden) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>

                        <!-- Wiraswasta -->
                        <div class="col-lg-4 col-md-6 col-12 border-end">
                            <div class="p-4 text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 70px; height: 70px;">
                                        <i class="bi bi-shop fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted mb-2 fw-semibold">Wiraswasta</h6>
                                <h2 class="fw-bold mb-2">{{ number_format($status['wiraswasta']) }}</h2>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $totalResponden > 0 ? ($status['wiraswasta'] / $totalResponden) * 100 : 0 }}%"></div>
                                </div>
                                <small class="text-primary fw-semibold">
                                    {{ $totalResponden > 0 ? number_format(($status['wiraswasta'] / $totalResponden) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>

                        <!-- Melanjutkan Studi -->
                        <div class="col-md-4">
                            <div class="p-4 text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info bg-opacity-10" style="width: 70px; height: 70px;">
                                        <i class="bi bi-mortarboard-fill fs-2 text-info"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted mb-2 fw-semibold">Melanjutkan Studi</h6>
                                <h2 class="fw-bold mb-2">{{ number_format($status['studi_lanjut']) }}</h2>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: {{ $totalResponden > 0 ? ($status['studi_lanjut'] / $totalResponden) * 100 : 0 }}%"></div>
                                </div>
                                <small class="text-info fw-semibold">
                                    {{ $totalResponden > 0 ? number_format(($status['studi_lanjut'] / $totalResponden) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-0 border-top">
                        <!-- Belum Bekerja -->
                        <div class="col-lg-6 col-md-6 col-12 border-end">
                            <div class="p-4 text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10" style="width: 70px; height: 70px;">
                                        <i class="bi bi-pause-circle-fill fs-2 text-warning"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted mb-2 fw-semibold">Belum Memungkinkan Bekerja</h6>
                                <h2 class="fw-bold mb-2">{{ number_format($status['belum_bekerja']) }}</h2>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $totalResponden > 0 ? ($status['belum_bekerja'] / $totalResponden) * 100 : 0 }}%"></div>
                                </div>
                                <small class="text-warning fw-semibold">
                                    {{ $totalResponden > 0 ? number_format(($status['belum_bekerja'] / $totalResponden) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>

                        <!-- Mencari Kerja -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="p-4 text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" style="width: 70px; height: 70px;">
                                        <i class="bi bi-search fs-2 text-danger"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted mb-2 fw-semibold">Tidak Bekerja / Mencari Kerja</h6>
                                <h2 class="fw-bold mb-2">{{ number_format($status['mencari_kerja']) }}</h2>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-danger" style="width: {{ $totalResponden > 0 ? ($status['mencari_kerja'] / $totalResponden) * 100 : 0 }}%"></div>
                                </div>
                                <small class="text-danger fw-semibold">
                                    {{ $totalResponden > 0 ? number_format(($status['mencari_kerja'] / $totalResponden) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- REKAP RESPONDEN --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            Rekap Responden Tracer per Program Studi
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Program Studi</th>
                        <th>Jumlah Alumni</th>
                        <th>Jumlah Responden</th>
                        <th>% Responden</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $totalAlumniTabel = 0;
                        $totalRespondenTabel = 0;
                    @endphp

                    @foreach($rekapProdi as $row)

                        @php
                            $totalAlumniTabel += $row['jumlah_alumni'];
                            $totalRespondenTabel += $row['jumlah_responden'];
                        @endphp

                        <tr>
                            <td>{{ $row['nama_prodi'] }}</td>
                            <td>{{ $row['jumlah_alumni'] }}</td>
                            <td>{{ $row['jumlah_responden'] }}</td>
                            <td>{{ $row['persentase'] }}%</td>
                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="table-secondary fw-bold">

                    <tr>
                        <td>TOTAL</td>

                        <td>{{ $totalAlumniTabel }}</td>

                        <td>{{ $totalRespondenTabel }}</td>

                        <td>
                            {{ $totalAlumniTabel > 0
                                ? round(($totalRespondenTabel / $totalAlumniTabel) * 100, 2)
                                : 0 }}%
                        </td>
                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

    {{-- INFORMASI --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <i class="bi bi-info-circle-fill text-maroon fs-3"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-2">Informasi Dashboard</h6>
                            <p class="mb-0 text-muted">
                                Data yang ditampilkan merupakan data real-time dari sistem tracer study alumni. 
                                Tingkat partisipasi dihitung berdasarkan perbandingan antara jumlah alumni yang telah 
                                menyelesaikan pengisian tracer study dengan total alumni yang terdaftar di sistem.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('Chart.js loaded:', typeof Chart !== 'undefined');
    
    // Data untuk chart
    const statusLabels = ['Bekerja', 'Wiraswasta', 'Belum Bekerja', 'Studi Lanjut', 'Mencari Kerja'];
    const statusValues = [
        {{ $status['bekerja'] ?? 0 }},
        {{ $status['wiraswasta'] ?? 0 }},
        {{ $status['belum_bekerja'] ?? 0 }},
        {{ $status['studi_lanjut'] ?? 0 }},
        {{ $status['mencari_kerja'] ?? 0 }}
    ];
    const statusColors = ['#28a745', '#0d6efd', '#ffc107', '#0dcaf0', '#dc3545'];
    const totalResponden = {{ $totalResponden ?? 0 }};

    console.log('Data:', { statusLabels, statusValues, totalResponden });

    // Bar Chart
    const ctxBar = document.getElementById('statusChart');
    if (ctxBar) {
        console.log('Bar chart canvas found');
        try {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Jumlah Alumni',
                        data: statusValues,
                        backgroundColor: statusColors,
                        borderRadius: 6,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: { 
                            display: false 
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    const percentage = totalResponden > 0 ? ((value / totalResponden) * 100).toFixed(1) : 0;
                                    return 'Jumlah: ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                stepSize: 1,
                                font: { size: 12 }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12 } }
                        }
                    }
                }
            });
            console.log('Bar chart created successfully');
        } catch (error) {
            console.error('Error creating bar chart:', error);
        }
    } else {
        console.error('Bar chart canvas not found');
    }

    // Pie Chart
    const ctxPie = document.getElementById('pieChart');
    if (ctxPie) {
        console.log('Pie chart canvas found');
        try {
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusValues,
                        backgroundColor: statusColors,
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.5,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 11 },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percentage = totalResponden > 0 ? ((value / totalResponden) * 100).toFixed(1) : 0;
                                        return {
                                            text: label + ': ' + value + ' (' + percentage + '%)',
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const percentage = totalResponden > 0 ? ((value / totalResponden) * 100).toFixed(1) : 0;
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
            console.log('Pie chart created successfully');
        } catch (error) {
            console.error('Error creating pie chart:', error);
        }
    } else {
        console.error('Pie chart canvas not found');
    }
});
</script>
@endpush