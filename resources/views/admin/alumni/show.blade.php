@extends('admin.layouts.app')

@section('title','Detail Alumni')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-eye-fill me-1"></i>
    Detail Alumni
</h4>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="30%">Nama Lengkap</th>
                <td>{{ $alumni->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>NIM</th>
                <td>{{ $alumni->nim }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $alumni->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $alumni->nik ?? '-' }}</td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td>{{ $alumni->prodi->nama_prodi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tahun Lulus</th>
                <td>{{ $alumni->tahun_lulus ?? '-' }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $alumni->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Desa</th>
                <td>{{ $alumni->desa ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <td>{{ $alumni->kecamatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kota / Kabupaten</th>
                <td>{{ $alumni->kota ?? '-' }}</td>
            </tr>
        </table>

    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.alumni.index') }}"
       class="btn btn-cream">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

@endsection
