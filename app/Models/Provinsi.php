<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsis';

    protected $fillable = [
        'id',
        'nama'
    ];
    
    public function kotas()
{
    return $this->hasMany(Kota::class);
}
}