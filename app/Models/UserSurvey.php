<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSurvey extends Model
{
    protected $fillable = [
        'alumni_id',
        'email',
        'token',
        'is_filled'
    ];

    protected $casts = [
        'is_filled' => 'boolean',
    ];
    protected static function booted()
    {
        static::creating(function ($survey) {
            if (!$survey->token) {
                $survey->token = \Illuminate\Support\Str::random(64);
            }
        });
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function answer()
    {
        return $this->hasOne(UserSurveyAnswer::class);
    }
}