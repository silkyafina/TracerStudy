<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerQuestionItem extends Model
{
    protected $fillable = [
        'tracer_question_id',
        'kode_item',
        'label',
        'urutan',
    ];

    // relasi ke pertanyaan
    public function question()
    {
        return $this->belongsTo(TracerQuestion::class, 'tracer_question_id');
    }

    // relasi ke jawaban
    public function answers()
    {
        return $this->hasMany(TracerAnswer::class);
    }
}
