<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Respon Pengguna Lulusan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 6px;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .ttd {
            width: 250px;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- ================= HEADER ================= --}}
    <div class="header">
        <h2>LAPORAN RESPON PENGGUNA LULUSAN</h2>
        <p>Program Studi {{ $namaProdi ?? 'Semua Program Studi' }}</p>
        <p>Periode Tahun Lulus 
            {{ request('tahun_dari') ?? '-' }} 
            s.d 
            {{ request('tahun_sampai') ?? '-' }}
        </p>
    </div>


    {{-- ================= TABEL ================= --}}
    @if($jenis == 'jumlah')

<table>
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Alumni Bekerja</th>
            <th>Responden</th>
            <th>Persentase</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->tahun_lulus }}</td>
            <td>{{ $row->alumni_bekerja }}</td>
            <td>{{ $row->jml_responden }}</td>
            <td>{{ number_format($row->persentase,2) }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif

@if($jenis == 'kompetensi')

<table>
    <thead>
        <tr>
            <th>Kompetensi</th>
            <th>Rata-rata</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Integritas</td>
            <td>{{ number_format($kompetensi->integritas ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Keahlian</td>
            <td>{{ number_format($kompetensi->keahlian ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Bahasa Inggris</td>
            <td>{{ number_format($kompetensi->bahasa_inggris ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Teknologi Informasi</td>
            <td>{{ number_format($kompetensi->teknologi_informasi ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Komunikasi</td>
            <td>{{ number_format($kompetensi->komunikasi ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Kerjasama Tim</td>
            <td>{{ number_format($kompetensi->kerjasama_tim ?? 0,2) }}</td>
        </tr>
        <tr>
            <td>Pengembangan Diri</td>
            <td>{{ number_format($kompetensi->pengembangan_diri ?? 0,2) }}</td>
        </tr>
    </tbody>
</table>

@endif



</body>
</html>