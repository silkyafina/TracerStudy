<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerQuestion extends Model
{
    protected $fillable = [
        'tracer_section_id',
        'kode_pertanyaan',
        'pertanyaan',
        'tipe_jawaban',
        'urutan',
    ];

    // relasi ke section
    public function section()
    {
        return $this->belongsTo(TracerSection::class, 'tracer_section_id');
    }

    // relasi ke item matrix
    public function items()
{
    return $this->hasMany(TracerQuestionItem::class, 'tracer_question_id');
}

    // relasi ke pilihan jawaban
    public function options()
    {
    return $this->hasMany(TracerOption::class)
                ->orderBy('urutan', 'asc');
    }


    // relasi ke jawaban alumni
    public function answers()
    {
        return $this->hasMany(TracerAnswer::class);
    }
}
