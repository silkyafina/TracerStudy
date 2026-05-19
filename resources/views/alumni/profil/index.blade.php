@extends('alumni.layouts.app')

@section('title', 'Profil Alumni')

@section('content')
<div class="container">

    <h5 class="mb-4">
        <i class="bi bi-person-circle me-2"></i>
        Profil Alumni
    </h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-borderless">
                <tr><th>Nama</th><td>{{ $alumni->nama_lengkap }}</td></tr>
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
                <tr><th>Kota / Kabupaten</th><td>{{ $alumni->kota ?? '-' }}</td></tr>
            </table>

            <a href="{{ route('alumni.profil.edit') }}" class="btn btn-maroon">
                <i class="bi bi-pencil me-1"></i> Edit Profil
            </a>
            <a href="{{ route('alumni.password.edit') }}" class="btn-outline-maroon">
                <i class="bi bi-key me-1"></i> Ubah Password
            </a>
            <a href="{{ route('alumni.dashboard') }}" class="btn btn-outline-secondary">
                Batal
            </a>
        </div>
    </div>

</div>
@endsection
