@extends('admin.layouts.app')

@section('title', 'Hasil Tracer Study')

@section('content')
<div class="container">
    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-bar-chart-fill me-1"></i>
            Hasil Tracer Study
        </h4>
        <a href="{{ route('admin.tracer.import.form') }}" class="btn btn-maroon">
            <i class="bi bi-upload me-1"></i>
            Import Excel
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
    
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Nama / NIM"
                           value="{{ request('search') }}">
                </div>
    
                <div class="col-md-2">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi_id" class="form-control">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->id }}"
                                {{ request('prodi_id')==$p->id ? 'selected':'' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="col-md-2">
                    <label class="form-label">Tahun Dari</label>
                    <select name="tahun_dari" class="form-control">
                        <option value="">-</option>
                        @foreach ($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_dari')==$t ? 'selected':'' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="col-md-2">
                    <label class="form-label">Tahun Sampai</label>
                    <select name="tahun_sampai" class="form-control">
                        <option value="">-</option>
                        @foreach ($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_sampai')==$t ? 'selected':'' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-maroon">
                        <i class="bi bi-funnel-fill me-1"></i>
                        Filter
                    </button>
    
                    <a href="{{ route('admin.tracer.results.index') }}"
                       class="btn btn-cream">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Reset
                    </a>
    
                    <a href="{{ route('admin.tracer.results.export', request()->all()) }}"
                        class="btn btn-maroon">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                      Excel
                     </a>
                </div>
    
    </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Tracer Diisi</th>
                        <th>Terakhir Isi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sessions as $i => $row)
                    <tr>
                        <td>{{ $sessions->firstItem() + $i }}</td>
                        <td>{{ $row->alumni->nama_lengkap }}</td>
                        <td>{{ $row->alumni->nim }}</td>
                        <td>{{ $row->alumni->prodi->nama_prodi ?? '-' }}</td>
                        <td>
                            <span class="badge bg-maroon">
                                {{ $row->total_tracer }} kali
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($row->last_filled)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.tracer.results.show', $row->alumni_id) }}"
                               class="btn btn-sm btn-cream"> <i class="bi bi-eye-fill"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
            <div class="mt-3">
            {{ $sessions->links() }}
            
        </div>
<script>
            setTimeout(() => {
    let alert = document.querySelector('.alert');
    if(alert){
        alert.classList.remove('show');
        alert.classList.add('fade');
    }
}, 3000);

    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
</script>
@endsection
