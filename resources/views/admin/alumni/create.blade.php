@extends('admin.layouts.app')

@section('title','Tambah Alumni')

@section('content')
<h4 class="mb-4">Tambah Data Alumni</h4>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.alumni.store') }}">
@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" 
               value="{{ old('nama_lengkap') }}" 
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">NIM</label>
        <input type="text" name="nim" 
               value="{{ old('nim') }}" 
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" 
               value="{{ old('tanggal_lahir') }}" 
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">NIK</label>
        <input type="text" name="nik" 
               value="{{ old('nik') }}" 
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Program Studi</label>
        <select name="prodi_id" class="form-control" required>
            <option value="">-- Pilih Prodi --</option>
            @foreach ($prodi as $p)
                <option value="{{ $p->id }}"
                    {{ old('prodi_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->kode_prodi }} - {{ $p->nama_prodi }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- TAHUN LULUS DROPDOWN --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Tahun Lulus</label>
        <select name="tahun_lulus" class="form-control">
            <option value="">-- Pilih Tahun --</option>
            @foreach ($tahunLulus as $tahun)
                <option value="{{ $tahun }}"
                    {{ old('tahun_lulus') == $tahun ? 'selected' : '' }}>
                    {{ $tahun }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" 
               value="{{ old('no_hp') }}" 
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Desa</label>
        <input type="text" name="desa" 
               value="{{ old('desa') }}" 
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kecamatan</label>
        <input type="text" name="kecamatan" 
               value="{{ old('kecamatan') }}" 
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kota / Kabupaten</label>
        <input type="text" name="kota" 
               value="{{ old('kota') }}" 
               class="form-control">
    </div>

</div>

<div class="mt-3">
    <button class="btn btn-maroon">
        <i class="bi bi-save me-1"></i>
        Simpan
    </button>
    <a href="{{ route('admin.alumni.index') }}" class="btn btn-cream">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

</form>
@endsection
