<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Alumni</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Tahun Lulus</th>
            <th>Nama Atasan</th>
            <th>NIP</th>
            <th>Jabatan Atasan</th>
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Integritas</th>
            <th>Keahlian</th>
            <th>Bahasa Inggris</th>
            <th>Teknologi Informasi</th>
            <th>Komunikasi</th>
            <th>Kerjasama Tim</th>
            <th>Pengembangan Diri</th>
            <th>Saran dan Masukan</th>

        </tr>
    </thead>
    <tbody>
        @foreach($answers as $key => $a)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $a->userSurvey->alumni->nama_lengkap }}</td>
            <td>{{ $a->userSurvey->alumni->nim }}</td>
            <td>{{ $a->userSurvey->alumni->prodi->nama_prodi }}</td>
            <td>{{ $a->userSurvey->alumni->tahun_lulus }}</td>
            <td>{{ $a->nama_atasan }}</td>
            <td>{{ $a->nip }}</td>
            <td>{{ $a->jabatan_atasan }}</td>
            <td>{{ $a->nama_perusahaan }}</td>
            <td>{{ $a->alamat_perusahaan }}</td>
            <td>{{ $a->integritas }}</td>
            <td>{{ $a->keahlian }}</td>
            <td>{{ $a->bahasa_inggris }}</td>
            <td>{{ $a->teknologi_informasi }}</td>
            <td>{{ $a->komunikasi }}</td>
            <td>{{ $a->kerjasama_tim }}</td>
            <td>{{ $a->pengembangan_diri }}</td>
            <td>{{ $a->saran }}</td>

        </tr>
        @endforeach
    </tbody>
</table>