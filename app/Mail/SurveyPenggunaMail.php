<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyPenggunaMail extends Mailable
{
    use SerializesModels;

    public $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Permohonan Pengisian Survey Evaluasi Lulusan')
                    ->view('emails.survey_pengguna');
    }
}