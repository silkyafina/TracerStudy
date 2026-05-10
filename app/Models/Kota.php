<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kotas';

    protected $fillable = [
        'id',
        'provinsi_id',
        'nama'
    ];
    public function provinsi()
{
    return $this->belongsTo(Provinsi::class);
}

}
