<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerSession extends Model
{
    protected $fillable = [
        'alumni_id',
        'status',
        'current_section',
        'started_at',
        'submitted_at',
    ];
    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
    ];
    
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function answers()
    {
        return $this->hasMany(TracerAnswer::class);
    }
}

