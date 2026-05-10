@extends('alumni.layouts.app')

@section('title','Tracer Study - Data Alumni')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-maroon text-white">
            <h5 class="mb-0">
                <i class="bi bi-person-vcard me-2"></i>
                Section 1 – Identitas Alumni
            </h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('alumni.tracer.section1.store') }}">
            @csrf

            {{-- DATA OTOMATIS --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ $alumni->nim }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $alumni->nama_lengkap }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Tahun Lulus</label>
                    <input type="text" class="form-control" value="{{ $alumni->tahun_lulus }}" readonly>
                </div>
                <div class="col-md-8">
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="{{ $alumni->prodi->nama_prodi ?? '-' }}" readonly>
                </div>
            </div>

            <hr>

            {{-- DATA DIISI ALUMNI --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>No HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Desa / Kelurahan</label>
                    <input type="text" name="desa" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Kota / Kabupaten</label>
                    <input type="text" name="kota" class="form-control" required>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('alumni.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-maroon">
                    Lanjut ke Section 2
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>

            </form>
        </div>
    </div>

</div>
@endsection
