@extends('admin.layouts.app')

@section('title', 'Laporan Respon Pengguna Lulusan')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4 fw-bold">
        <i class="bi bi-bar-chart-line"></i>
        Laporan Respon Pengguna Lulusan
    </h4>

    {{-- ================= FILTER ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row g-3">

                    <div class="col-md-2">
                        <label class="form-label">Cari</label>
                        <input type="text" name="cari" class="form-control"
                               value="{{ request('cari') }}"
                               placeholder="Nama / Perusahaan">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tahun Dari</label>
                        <select name="tahun_dari" class="form-select">
                            <option value="">--</option>
                            @foreach($tahunList as $t)
                                <option value="{{ $t }}" {{ request('tahun_dari')==$t?'selected':'' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tahun Sampai</label>
                        <select name="tahun_sampai" class="form-select">
                            <option value="">--</option>
                            @foreach($tahunList as $t)
                                <option value="{{ $t }}" {{ request('tahun_sampai')==$t?'selected':'' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select">
                            <option value="">-- Semua --</option>
                            @foreach($prodiList as $p)
                                <option value="{{ $p->id }}" {{ request('prodi_id')==$p->id?'selected':'' }}>
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jenis Data</label>
                        <select name="jenis" class="form-select">
                            <option value="jumlah" {{ request('jenis','jumlah')=='jumlah'?'selected':'' }}>
                                Jumlah
                            </option>
                            <option value="kompetensi" {{ request('jenis')=='kompetensi'?'selected':'' }}>
                                Penilaian Kompetensi
                            </option>
                            <option value="saran">Saran & Masukan</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-maroon w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- ================= DATA JUMLAH ================= --}}
    @if(request('jenis','jumlah') == 'jumlah' && isset($data) && $data->count())

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-cream text-white">
            <div>
                <a href="{{ route('admin.laporan.pengguna.excel', request()->all()) }}"
                   class="btn btn-maroon">
                   <i class="bi bi-file-excel"></i> Excel
                </a>

                <a href="{{ route('admin.laporan.pengguna.pdf', request()->all()) }}"
                   class="btn btn-maroon">
                   <i class="bi bi-file-pdf"></i> PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tahun Lulus</th>
                        <th>Alumni Bekerja</th>
                        <th>Responden Pengguna</th>
                        <th>Persentase (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $row->tahun_lulus }}</td>
                            <td>{{ $row->alumni_bekerja }}</td>
                            <td>{{ $row->jml_responden }}</td>
                            <td>{{ $row->persentase }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
       

    {{-- CHART JUMLAH --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
            <button onclick="downloadChart('chartPengguna','chart_pengguna.png')" 
                    class="btn btn-maroon mb-3">
                    <i class="bi bi-download"></i> Download PNG
            </button>
            <canvas id="chartPengguna"></canvas>
        </div>
        
    </div>

    @endif


    {{-- ================= DATA KOMPETENSI ================= --}}
    @if(request('jenis') == 'kompetensi' && isset($kompetensi))

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-cream text-white">
            <div>
                <a href="{{ route('admin.laporan.pengguna.excel', request()->all()) }}"
                   class="btn btn-maroon">
                   <i class="bi bi-file-excel"></i> Excel
                </a>

                <a href="{{ route('admin.laporan.pengguna.pdf', request()->all()) }}"
                   class="btn btn-maroon">
                   <i class="bi bi-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kompetensi</th>
                        <th>Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        'Integritas' => $kompetensi->integritas ?? 0,
                        'Keahlian' => $kompetensi->keahlian ?? 0,
                        'Bahasa Inggris' => $kompetensi->bahasa_inggris ?? 0,
                        'Teknologi Informasi' => $kompetensi->teknologi_informasi ?? 0,
                        'Komunikasi' => $kompetensi->komunikasi ?? 0,
                        'Kerjasama Tim' => $kompetensi->kerjasama_tim ?? 0,
                        'Pengembangan Diri' => $kompetensi->pengembangan_diri ?? 0,
                    ] as $label => $nilai)

                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ number_format($nilai,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    {{-- CHART KOMPETENSI --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
            <button onclick="downloadChart('chartKompetensi','chart_kompetensi.png')" 
                    class="btn btn-maroon mb-3">
                    <i class="bi bi-download"></i> Download PNG
            </button>
            <canvas id="chartKompetensi"></canvas>
        </div>
    </div>

    @endif
    @if($jenis == 'saran')

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alumni</th>
                    <th>Tahun Lulus</th>
                    <th>Perusahaan</th>
                    <th>Saran & Masukan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->tahun_lulus }}</td>
                        <td>{{ $item->nama_perusahaan }}</td>
                        <td style="white-space: normal;">
                            {{ $item->saran }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Tidak ada data saran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @endif
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(request('jenis','jumlah') == 'jumlah' && isset($data) && $data->count())
<script>
new Chart(document.getElementById('chartPengguna'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($data->pluck('tahun_lulus')) !!},
        datasets: [
            {
                label: 'Alumni Bekerja',
                data: {!! json_encode($data->pluck('alumni_bekerja')) !!}
            },
            {
                label: 'Responden Pengguna',
                data: {!! json_encode($data->pluck('jml_responden')) !!}
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } }
    }
});
</script>
@endif


@if(request('jenis') == 'kompetensi' && isset($kompetensi))
<script>
new Chart(document.getElementById('chartKompetensi'), {
    type: 'bar',
    data: {
        labels: [
            'Integritas','Keahlian','Bahasa Inggris',
            'Teknologi Informasi','Komunikasi',
            'Kerjasama Tim','Pengembangan Diri'
        ],
        datasets: [{
            label: 'Rata-rata Kompetensi',
            data: [
                {{ $kompetensi->integritas ?? 0 }},
                {{ $kompetensi->keahlian ?? 0 }},
                {{ $kompetensi->bahasa_inggris ?? 0 }},
                {{ $kompetensi->teknologi_informasi ?? 0 }},
                {{ $kompetensi->komunikasi ?? 0 }},
                {{ $kompetensi->kerjasama_tim ?? 0 }},
                {{ $kompetensi->pengembangan_diri ?? 0 }}
            ]
        }]
    },
    options: {
        responsive: true,
        scales: { y: { min: 0, max: 10 } }
    }
});
</script>
@endif


<script>
function downloadChart(canvasId, filename) {
    const link = document.createElement('a');
    link.href = document.getElementById(canvasId).toDataURL('image/png');
    link.download = filename;
    link.click();
}
</script>
@endpush