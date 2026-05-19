<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
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
    public function UserSurvey()
    {
        return $this->belongsTo(UserSurvey::class);
    }
    public function tracerSessions()
{
    return $this->hasMany(TracerSession::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}

