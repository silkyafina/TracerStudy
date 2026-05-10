<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Prodi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
{
    foreach ($rows as $row) {

        // 🔍 mapping prodi dari nama
        $prodi = Prodi::where('nama_prodi', $row['program_studi'])->first();

        if (!$prodi) {
            continue; // skip kalau tidak ketemu
        }

        // 🔄 convert tanggal excel ke format Y-m-d
        $tanggal = null;
        if (!empty($row['tanggal_lahir'])) {
            $tanggal = Date::excelToDateTimeObject($row['tanggal_lahir'])
                ->format('Y-m-d');
        }

        Alumni::updateOrCreate(
            ['nim' => $row['nim']],
            [
                'nama_lengkap'  => $row['nama_lengkap'],
                'tanggal_lahir' => $tanggal,
                'nik'           => $row['nik'],
                'prodi_id'      => $prodi->id,
                'tahun_lulus'   => $row['tahun_lulus'],
                'no_hp'         => $row['no_hp'],
                'desa'          => $row['desa'],
                'kecamatan'     => $row['kecamatan'],
                'kota'          => $row['kota'],
            ]
        );
    }
}
}