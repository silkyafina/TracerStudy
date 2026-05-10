<?php

namespace App\Imports;

use App\Models\UserSurveyAnswer;
use App\Models\Alumni;
use App\Models\UserSurvey;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class UserSurveyAnswerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
{
    foreach ($rows as $row) {

        // 🔍 cari alumni
        $alumni = Alumni::where('nim', (string)$row['nim'])->first();

        if (!$alumni) continue;
        // 🔥 FIX DI SINI (WAJIB)
        $userSurvey = UserSurvey::firstOrCreate([
            'alumni_id' => $alumni->id
        ]);

        // 💾 simpan jawaban
        UserSurveyAnswer::updateOrCreate(
            ['user_survey_id' => $userSurvey->id],
            [
                'integritas' => $row['integritas'],
                'keahlian' => $row['keahlian'],
                'bahasa_inggris' => $row['bahasa_inggris'],
                'teknologi_informasi' => $row['teknologi_informasi'],
                'komunikasi' => $row['komunikasi'],
                'kerjasama_tim' => $row['kerjasama_tim'],
                'pengembangan_diri' => $row['pengembangan_diri'],

                'nama_atasan' => $row['nama_atasan'],
                'nip' => $row['nip'] ?? null,
                'jabatan_atasan' => $row['jabatan_atasan'],
                'nama_perusahaan' => $row['nama_perusahaan'],
                'alamat_perusahaan' => $row['alamat_perusahaan'],
                'saran' => $row['saran_dan_masukan'] ?? null,
            ]
        );
    }
}
 
}