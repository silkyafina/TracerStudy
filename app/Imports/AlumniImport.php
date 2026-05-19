<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $prodi = Prodi::where('nama_prodi', $row['program_studi'])->first();

            if (!$prodi) {
                continue;
            }

            $tanggal = null;
            if (!empty($row['tanggal_lahir'])) {
                $tanggal = Date::excelToDateTimeObject($row['tanggal_lahir'])
                    ->format('Y-m-d');
            }

            $alumni = Alumni::updateOrCreate(
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

            // 🔑 CREATE / UPDATE USER LOGIN
            User::updateOrCreate(
                [
                    'username' => $row['nim'],
                    'role' => 'alumni'
                ],
                [
                    'alumni_id' => $alumni->id,
                    'name' => $row['nama_lengkap'],
                    'password' => Hash::make($tanggal), // DOB sebagai default password
                    'must_change_password' => true,
                ]
            );
        }
    }
}