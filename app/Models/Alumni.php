<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\TracerSession;
use App\Models\UserSurvey;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'tanggal_lahir',
        'nik',
        'prodi_id',
        'tahun_lulus',
        'no_hp',
        'desa',
        'kecamatan',
        'kota'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function tracerSessions()
    {
        return $this->hasMany(TracerSession::class);
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}