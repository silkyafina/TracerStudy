@extends('admin.layouts.app')

@section('title','Data Alumni')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@php
    $isAdmin = auth()->guard('admin')->user()->role == 'admin';
@endphp
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">
        <i class="bi bi-people-fill me-1"></i>
        Data Alumni
    </h4>
    
    <div class="d-flex gap-2">
   
        @if($isAdmin)
        <a href="{{ route('admin.alumni.create') }}" class="btn btn-maroon">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Alumni
        </a>
  

        <a href="{{ route('admin.alumni.import.form') }}" class="btn btn-cream">
            <i class="bi bi-upload me-1"></i>
            Import Excel
        </a>
        @endif
    </div>
   
</div>

{{-- FILTER --}}
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
                <label class="form-label">Tahun Lulus dari</label>
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
                <label class="form-label">Tahun Lulus sampai</label>
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
            <div class="col-md-2">
                <label class="form-label">Status Tracer</label>
                <select name="status_tracer" class="form-control">
                    <option value="">Semua</option>
                    <option value="sudah" {{ request('status_tracer')=='sudah' ? 'selected':'' }}>
                        Sudah Isi
                    </option>
                    <option value="belum" {{ request('status_tracer')=='belum' ? 'selected':'' }}>
                        Belum Isi
                    </option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-maroon">
                    <i class="bi bi-funnel-fill me-1"></i>
                    Filter
                </button>

                <a href="{{ route('admin.alumni.index') }}"
                   class="btn btn-cream">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Reset
                </a>

                <a href="{{ route('admin.alumni.export', request()->all()) }}"
                   class="btn btn-maroon">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    Export
                </a>
            </div>

        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Tahun Lulus</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alumni as $a)
                <tr>
                    <td>{{ $a->nim }}</td>
                    <td>{{ $a->nama_lengkap }}</td>
                    <td>{{ $a->prodi->nama_prodi ?? '-' }}</td>
                    <td>{{ $a->tahun_lulus ?? '-' }}</td> 
                    <td>
                        @if($a->tracerSessions->count() > 0)
                        <span class="badge bg-maroon badge-sm">
                            <i class="bi bi-check-circle"> Sudah Isi</i>
                        </span>
                        @else
                        <span class="badge bg-cream badge-sm">
                            <i class="bi bi-x-circle"></i> Belum
                        </span>
                        @endif
                    </td>
                    <td class="text-center">

                        <a href="{{ route('admin.alumni.show',$a->id) }}"
                           class="btn btn-sm btn-maroon"
                           title="Detail">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        @if($isAdmin)
                        <a href="{{ route('admin.alumni.edit',$a->id) }}"
                           class="btn btn-sm btn-cream"
                           title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @else
                        <button class="btn btn-secondary btn-sm disabled-btn"
                        data-bs-toggle="tooltip"
                        title="Tidak memiliki akses Edit">
                        <i class="bi bi-lock"></i>
                        </button>
                    @endif
                    @if($isAdmin)
                        <form action="{{ route('admin.alumni.destroy',$a->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data alumni?')"
                                    class="btn btn-sm btn-maroon"
                                    title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary btn-sm disabled-btn"
                        data-bs-toggle="tooltip"
                        title="Tidak memiliki akses Delete">
                        <i class="bi bi-lock"></i>
                        </button>
                        @endif
                        <form action="{{ route('admin.alumni.reset-password', $a->id) }}"
                            method="POST"
                            class="d-inline">
                          @csrf
                      
                          <button type="submit"
                                  class="btn btn-sm btn-cream"
                                  title="Reset Password"
                                  onclick="return confirm('Reset password alumni ini?')">
                              <i class="bi bi-key-fill"></i>
                          </button>
                      </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="bi bi-info-circle"></i>
                        Data tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $alumni->links() }}
</div>

{{-- VALIDASI RANGE TAHUN --}}
<script>
document.querySelector('form').addEventListener('submit', function(e){
    const dari = document.querySelector('[name="tahun_dari"]').value;
    const sampai = document.querySelector('[name="tahun_sampai"]').value;

    if(dari && sampai && parseInt(sampai) < parseInt(dari)){
        e.preventDefault();
        alert('Tahun sampai tidak boleh lebih kecil dari tahun dari');
    }
});
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
