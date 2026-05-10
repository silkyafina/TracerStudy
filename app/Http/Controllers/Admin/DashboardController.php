<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\TracerAnswer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlumni = Alumni::count();

        // Ambil semua jawaban status kerja (Q9)
        $statusAnswers = TracerAnswer::join(
                'tracer_sessions',
                'tracer_answers.tracer_session_id',
                '=',
                'tracer_sessions.id'
            )
            ->where('tracer_answers.tracer_question_id', 9)
            ->select(
                'tracer_sessions.alumni_id',
                'tracer_answers.value'
            )
            ->get()
            ->unique('alumni_id'); // 1 alumni = 1 data

        // Total responden
        $totalResponden = $statusAnswers->count();

        // Inisialisasi
        $status = [
            'bekerja' => 0,
            'wiraswasta' => 0,
            'belum_bekerja' => 0,
            'studi_lanjut' => 0,
            'mencari_kerja' => 0,
        ];

        // Hitung status
        foreach ($statusAnswers as $answer) {
            match ((int) $answer->value) {
                1 => $status['bekerja']++,
                2 => $status['belum_bekerja']++,
                3 => $status['wiraswasta']++,
                4 => $status['studi_lanjut']++,
                5 => $status['mencari_kerja']++,
                default => null,
            };
        }

        return view('admin.dashboard', compact(
            'totalAlumni',
            'totalResponden',
            'status'
        ));
    }
}