<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';

    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}


