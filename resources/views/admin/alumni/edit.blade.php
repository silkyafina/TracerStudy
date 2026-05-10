@extends('admin.layouts.app')

@section('title','Edit Alumni')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-pencil-square me-1"></i>
    Edit Data Alumni
</h4>

<form method="POST" action="{{ route('admin.alumni.update', $alumni->id) }}">
@csrf
@method('PUT')
@if ($errors->any())
    <div class="alert alert-danger">
        {{ implode('', $errors->all(':message')) }}
    </div>
@endif
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="nama_lengkap"
                       class="form-control"
                       value="{{ old('nama_lengkap',$alumni->nama_lengkap) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">NIM</label>
                <input type="text"
                       name="nim"
                       class="form-control"
                       value="{{ old('nim',$alumni->nim) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date"
                       name="tanggal_lahir"
                       class="form-control"
                       value="{{ old('tanggal_lahir',$alumni->tanggal_lahir) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">NIK</label>
                <input type="text"
                       name="nik"
                       class="form-control"
                       value="{{ old('nik',$alumni->nik) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Program Studi</label>
                <select name="prodi_id" class="form-control" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id }}"
                            {{ old('prodi_id',$alumni->prodi_id)==$p->id ? 'selected':'' }}>
                            {{ $p->kode_prodi }} - {{ $p->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun Lulus</label>
                <select name="tahun_lulus" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($t = date('Y'); $t >= 2000; $t--)
                        <option value="{{ $t }}"
                            {{ old('tahun_lulus',$alumni->tahun_lulus)==$t ? 'selected':'' }}>
                            {{ $t }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">No HP</label>
                <input type="text"
                       name="no_hp"
                       class="form-control"
                       value="{{ old('no_hp',$alumni->no_hp) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Desa</label>
                <input type="text"
                       name="desa"
                       class="form-control"
                       value="{{ old('desa',$alumni->desa) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Kecamatan</label>
                <input type="text"
                       name="kecamatan"
                       class="form-control"
                       value="{{ old('kecamatan',$alumni->kecamatan) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Kota / Kabupaten</label>
                <input type="text"
                       name="kota"
                       class="form-control"
                       value="{{ old('kota',$alumni->kota) }}">
            </div>

        </div>
    </div>
</div>

<div class="mt-3">
    <button class="btn btn-maroon" type="submit">
        <i class="bi bi-save me-1"></i>
        Update
    </button>

    <a href="{{ route('admin.alumni.index') }}"
       class="btn btn-cream">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

</form>
@endsection
