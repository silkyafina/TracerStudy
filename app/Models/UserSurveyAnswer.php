<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSurveyAnswer extends Model
{
    protected $fillable = [
        'user_survey_id',
        'integritas',
        'keahlian',
        'bahasa_inggris',
        'teknologi_informasi',
        'komunikasi',
        'kerjasama_tim',
        'pengembangan_diri',
        'nama_atasan',
        'nip',
        'jabatan_atasan',
        'nama_perusahaan',
        'alamat_perusahaan',
        'saran',
    ];

    public function userSurvey()
    {
        return $this->belongsTo(UserSurvey::class);
    }
}