@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Detail Penilaian</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5>Data Alumni</h5>
            <p><strong>Nama:</strong> {{ $answer->userSurvey->alumni->nama_lengkap }}</p>

            <hr>

            <h5>Penilaian Kompetensi</h5>
            <ul>
                <li>Integritas: {{ $answer->integritas }}</li>
                <li>Keahlian: {{ $answer->keahlian }}</li>
                <li>Bahasa Inggris: {{ $answer->bahasa_inggris }}</li>
                <li>Teknologi Informasi: {{ $answer->teknologi_informasi }}</li>
                <li>Komunikasi: {{ $answer->komunikasi }}</li>
                <li>Kerjasama Tim: {{ $answer->kerjasama_tim }}</li>
                <li>Pengembangan Diri: {{ $answer->pengembangan_diri }}</li>
            </ul>

            <hr>

            <h5>Identitas Penilai</h5>
            <p>Nama Atasan: {{ $answer->nama_atasan }}</p>
            <p>Jabatan: {{ $answer->jabatan_atasan }}</p>
            <p>Perusahaan: {{ $answer->nama_perusahaan }}</p>
            <p>Alamat: {{ $answer->alamat_perusahaan }}</p>

            <hr>

            <h5>Saran</h5>
            <p>{{ $answer->saran ?? '-' }}</p>

        </div>
    </div>
</div>
@endsection