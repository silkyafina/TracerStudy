@extends('survey.app')

@section('content')

<h4 class="page-title mb-4 text-center">
    FORM PENILAIAN PENGGUNA LULUSAN
</h4>

{{-- IDENTITAS ALUMNI --}}
<div class="card shadow-sm mb-4">
    <div class="card-header">
        Identitas Alumni
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr>
                <td width="30%">Nama Alumni</td>
                <td>: {{ $alumni->nama_lengkap ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>
                    : {{ ($alumni->desa ?? '-') . ', Kec. ' . ($alumni->kecamatan ?? '-') . ', ' . ($alumni->kota ?? '-') }}
                </td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $alumni->prodi->nama_prodi ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>

<form method="POST" action="{{ url('/survey/pengguna/' . $survey->token) }}">
@csrf

<div class="card shadow-sm mb-4">
    <div class="card-header">
        Penilaian Kompetensi Lulusan
    </div>
    <div class="card-body">

        @php
        $options = [
            5 => 'Sangat Baik',
            4 => 'Baik',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Tidak Baik',
        ];
        @endphp

        @foreach([
            'integritas' => 'Integritas (Etika dan Moral)',
            'keahlian' => 'Keahlian Sesuai Bidang Ilmu',
            'bahasa_inggris' => 'Kemampuan Bahasa Inggris',
            'teknologi_informasi' => 'Penguasaan Teknologi Informasi',
            'komunikasi' => 'Kemampuan Komunikasi',
            'kerjasama_tim' => 'Kerja Sama Tim',
            'pengembangan_diri' => 'Pengembangan Diri',
        ] as $name => $label)

        <div class="mb-4">
            <label class="form-label fw-semibold">{{ $label }}</label>
            <div>
                @foreach($options as $value => $text)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               name="{{ $name }}"
                               value="{{ $value }}"
                               required>
                        <label class="form-check-label">{{ $text }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        @endforeach

    </div>
</div>

{{-- IDENTITAS PENILAI --}}
<div class="card shadow-sm mb-4">
    <div class="card-header">
        Identitas Penilai
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Nama Atasan</label>
            <input type="text" name="nama_atasan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">NIP/NIPY/NIK</label>
            <input type="text" name="nip" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan_atasan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Instansi/Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Instansi/Perusahaan</label>
            <textarea name="alamat_perusahaan" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Saran dan Masukan</label>
            <textarea name="saran" class="form-control" rows="3"></textarea>
        </div>

    </div>
</div>

<div class="text-end">
    <button type="submit" class="btn btn-primary px-4">
        Kirim Penilaian
    </button>
</div>

</form>
@endsection