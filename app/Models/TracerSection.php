<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerSection extends Model
{
    protected $fillable = [
        'urutan',
        'nama_section',
        'deskripsi',
    ];

    // relasi: 1 section punya banyak pertanyaan
    public function questions()
    {
        return $this->hasMany(TracerQuestion::class);
    }
}
