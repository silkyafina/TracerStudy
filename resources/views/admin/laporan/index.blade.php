@extends('admin.layouts.app')

@section('title', 'Laporan Tracer Study')

@section('content')
<div class="container-fluid">
    {{-- =========================
        JUDUL
    ========================= --}}
    
    <h4 class="mb-4"> 
        <i class="bi bi-file-earmark-text fill me-1"></i>
        Laporan Tracer Study Alumni
    </h4>

    {{-- =========================
        FILTER LAPORAN
    ========================= --}}
    <div class="card shadow-sm mb-4" style="overflow: visible;">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="row g-3 align-items-end">
            
                    <div class="col-md-2">
                        <label>Tahun Dari</label>
                        <select name="tahun_dari" class="form-control">
                            <option value="">-</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t }}" {{ request('tahun_dari')==$t?'selected':'' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col-md-2">
                        <label>Tahun Sampai</label>
                        <select name="tahun_sampai" class="form-control">
                            <option value="">-</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t }}" {{ request('tahun_sampai')==$t?'selected':'' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Status Alumni</label>
                        <select name="kategori" class="form-control">
                            <option value="">Semua</option>
                            <option value="1" {{ request('kategori')=='1'?'selected':'' }}>
                                Bekerja
                            </option>
                            <option value="2,5" {{ request('kategori')=='2,5'?'selected':'' }}>
                                Belum memungkinkan bekerja dan Tidak Kerja tetapi sedang mencari kerja
                            </option>
                            <option value="3" {{ request('kategori')=='3'?'selected':'' }}>
                                Wiraswasta
                            </option>
                            <option value="4" {{ request('kategori')=='4'?'selected':'' }}>
                                Melanjutkan Pendidikan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-control">
                            <option value="">Semua</option>
                            @foreach($prodi as $p)
                                <option value="{{ $p->id }}" {{ request('prodi_id')==$p->id?'selected':'' }}>
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col-md-3">
                        <label>Data Laporan</label>
                        <select name="tracer_question_id" class="form-control" required>
                            <option value="">-- Pilih Pertanyaan --</option>
                            @foreach($pertanyaan as $q)
                                <option value="{{ $q->id }}" {{ request('tracer_question_id')==$q->id?'selected':'' }}>
                                    {{ $q->pertanyaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col-md-2">
                        <button class="btn btn-maroon w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
            
                </div>
            </form>
            
                
        </div>
    </div>

{{-- =========================
HASIL LAPORAN
========================= --}}
@if($question)

    {{-- ================= TEXT ================= --}}
    @if($question && $question->tipe_jawaban === 'text')

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-cream text-white">
                <h6 class="mb-0">{{ $judulLaporan }}</h6>
                <div>
                    <a href="{{ route('admin.laporan.export.excel', request()->all()) }}"
                       class="btn btn-cream">
                        <i class="bi bi-file-excel"></i> Excel
                    </a>

                    <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}"
                       class="btn btn-cream">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <p><strong>Total Responden:</strong> {{ count($table) }}</p>

                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Tahun</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($table as $row)
                            <tr>
                                <td class="text-center">{{ $row['no'] }}</td>
                                <td class="text-center">{{ $row['tahun'] }}</td>
                                <td>{{ $row['jawaban'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    {{-- ================= MATRIX ================= --}}
    @elseif($isMatrix)

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-cream text-white">
                <h6 class="mb-0">{{ $judulLaporan }}</h6>
                <div>
                    <a href="{{ route('admin.laporan.export.excel', request()->all()) }}"
                       class="btn btn-maroon">
                       <i class="bi bi-file-earmark-excel me-1"></i> Excel
                    </a>

                    <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}"
                       class="btn btn-maroon">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Tahun</th>
                            @foreach($categories as $cat)
                                <th>{{ $cat }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matrixTable as $row)
                            <tr>
                                <td>{{ $row['tahun'] }}</td>
                                @foreach($categories as $cat)
                                    <td>{{ $row[$cat] ?? 0 }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h6 class="mb-0">Diagram Batang</h6>
                
                    <button id="downloadChart"
                            class="btn btn-maroon">
                        <i class="bi bi-download"></i> Download PNG
                    </button>
                </div>
                
                <canvas id="laporanChart" height="100"></canvas>
            </div>
        </div>

    {{-- ================= CHECKBOX / RADIO (PIVOT) ================= --}}
    @else

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-maroon text-white">
                <h6 class="mb-0">{{ $judulLaporan }}</h6>
                <div>
                    <a href="{{ route('admin.laporan.export.excel', request()->all()) }}"
                       class="btn btn-cream">
                        <i class="bi bi-file-earmark-excel me-1"></i> Excel
                    </a>

                    <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}"
                       class="btn btn-cream">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2">Tahun Lulus</th>

                            @foreach($categories as $cat)
                                <th colspan="2">{{ $cat }}</th>
                            @endforeach

                            <th rowspan="2">Total</th>
                        </tr>
                        <tr>
                            @foreach($categories as $cat)
                                <th>Jumlah</th>
                                <th>%</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $grandTotal = 0;
                            $categoryTotals = array_fill_keys($categories->toArray(), 0);
                        @endphp

                        @foreach($table as $row)
                            @php $rowTotal = $row['total'] ?? 0; @endphp
                            <tr>
                                <td><strong>{{ $row['tahun'] }}</strong></td>

                                @foreach($categories as $cat)
                                    @php
                                        $jumlah = $row[$cat] ?? 0;
                                        $persen = $rowTotal > 0
                                            ? round(($jumlah / $rowTotal) * 100, 2)
                                            : 0;

                                        $categoryTotals[$cat] += $jumlah;
                                    @endphp

                                    <td>{{ $jumlah }}</td>
                                    <td>{{ $persen }}%</td>
                                @endforeach

                                <td><strong>{{ $rowTotal }}</strong></td>
                            </tr>

                            @php $grandTotal += $rowTotal; @endphp
                        @endforeach
                    </tbody>

                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td>Total</td>

                            @foreach($categories as $cat)
                                @php
                                    $jumlah = $categoryTotals[$cat];
                                    $persen = $grandTotal > 0
                                        ? round(($jumlah / $grandTotal) * 100, 2)
                                        : 0;
                                @endphp

                                <td>{{ $jumlah }}</td>
                                <td>{{ $persen }}%</td>
                            @endforeach

                            <td>{{ $grandTotal }}</td>
                        </tr>
                    </tfoot>

                </table>
                <hr>
           
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h6 class="mb-0">Diagram Batang</h6>
                
                    <button id="downloadChart"
                            class="btn btn-maroon">
                        <i class="bi bi-download"></i> Download PNG
                    </button>
                </div>
                
                <canvas id="laporanChart" height="100"></canvas>
        </div>
        </div>

    @endif

@endif
@if($question && $question->tipe_jawaban !== 'text')
<script>
document.addEventListener("DOMContentLoaded", function() {

    const ctx = document.getElementById('laporanChart');
    if (!ctx) return;

    @if($isMatrix)

        // ================= MATRIX PER TAHUN =================

        const rawData = @json($matrixTable);
        const categories = @json($categories);

        const labels = rawData.map(row => row.tahun);

        const datasets = categories.map(cat => {
            return {
                label: cat,
                data: rawData.map(row => row[cat] ?? 0),
                borderWidth: 1
            }
        });

    @else

        // ================= CHECKBOX / RADIO PER TAHUN =================

        const rawData = @json($table);
        const categories = @json($categories);

        const labels = rawData.map(row => row.tahun);

        const datasets = categories.map(cat => {
            return {
                label: cat,
                data: rawData.map(row => row[cat] ?? 0),
                borderWidth: 1
            }
        });

    @endif

    const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});



document.getElementById('downloadChart')
    ?.addEventListener('click', function () {

        const link = document.createElement('a');
        link.download = 'diagram_tracer.png';
        link.href = myChart.toBase64Image();
        link.click();
});
});
</script>
@endif
@endsection