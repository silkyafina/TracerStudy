<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerAnswer extends Model
{
    protected $fillable = [
        'tracer_session_id',
        'tracer_question_id',
        'tracer_item_id',
        'value'
    ];

    public function question()
    {
        return $this->belongsTo(TracerQuestion::class, 'tracer_question_id');
    }
    public function selectedOption()
    {
        return $this->belongsTo(TracerOption::class, 'value');
    }

    public function item()
    {
        return $this->belongsTo(TracerQuestionItem::class);
    }

    public function session()
    {
        return $this->belongsTo(TracerSession::class);
    }
}
