<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerOption extends Model
{
    protected $fillable = [
        'tracer_question_id',
        'label',
        'value',
        'urutan',
    ];

    // relasi ke pertanyaan
    public function question()
    {
        return $this->belongsTo(TracerQuestion::class, 'tracer_question_id');
    }
}
