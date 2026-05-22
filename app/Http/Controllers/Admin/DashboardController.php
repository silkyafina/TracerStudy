<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Prodi;
use App\Models\TracerAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = range(date('Y'), 2000);
        $prodi = Prodi::all();

        // =========================
        // FILTER ALUMNI
        // =========================
        $alumniQuery = Alumni::query();

        // Filter Prodi
        if ($request->filled('prodi_id')) {
            $alumniQuery->where('prodi_id', $request->prodi_id);
        }

        // Filter Tahun Lulus
        if ($request->filled('tahun_dari') && $request->filled('tahun_sampai')) {

            if ($request->tahun_sampai < $request->tahun_dari) {
                return back()->with('error', 'Tahun sampai tidak boleh lebih kecil');
            }

            $alumniQuery->whereBetween('tahun_lulus', [
                $request->tahun_dari,
                $request->tahun_sampai
            ]);
        }

        // Ambil ID alumni hasil filter
        $alumniIds = $alumniQuery->pluck('id');

        // =========================
        // TOTAL ALUMNI
        // =========================
        $totalAlumni = $alumniIds->count();

        // =========================
        // STATUS PEKERJAAN
        // =========================
        $statusAnswers = TracerAnswer::join(
                'tracer_sessions',
                'tracer_answers.tracer_session_id',
                '=',
                'tracer_sessions.id'
            )
            ->where('tracer_answers.tracer_question_id', 9)
            ->whereIn('tracer_sessions.alumni_id', $alumniIds)
            ->select(
                'tracer_sessions.alumni_id',
                'tracer_answers.value'
            )
            ->get()
            ->unique('alumni_id');

        // Total responden
        $totalResponden = $statusAnswers->count();

        // Inisialisasi status
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

        // =========================
        // REKAP PER PRODI
        // =========================
        $rekapProdi = Prodi::all()->map(function ($p) use ($request) {

            // Query alumni per prodi
            $alumni = Alumni::where('prodi_id', $p->id);

            // Filter tahun
            if ($request->filled('tahun_dari') && $request->filled('tahun_sampai')) {
                $alumni->whereBetween('tahun_lulus', [
                    $request->tahun_dari,
                    $request->tahun_sampai
                ]);
            }

            $alumniIds = $alumni->pluck('id');

            $jumlahAlumni = $alumniIds->count();

            // Responden tracer
            $jumlahResponden = TracerAnswer::join(
                    'tracer_sessions',
                    'tracer_answers.tracer_session_id',
                    '=',
                    'tracer_sessions.id'
                )
                ->where('tracer_answers.tracer_question_id', 9)
                ->whereIn('tracer_sessions.alumni_id', $alumniIds)
                ->distinct('tracer_sessions.alumni_id')
                ->count('tracer_sessions.alumni_id');

            return [
                'nama_prodi' => $p->nama_prodi,
                'jumlah_alumni' => $jumlahAlumni,
                'jumlah_responden' => $jumlahResponden,
                'persentase' => $jumlahAlumni > 0
                    ? round(($jumlahResponden / $jumlahAlumni) * 100, 2)
                    : 0
            ];
        });

        return view('admin.dashboard', compact(
            'totalAlumni',
            'totalResponden',
            'status',
            'tahun',
            'prodi',
            'rekapProdi'
        ));
    }
}