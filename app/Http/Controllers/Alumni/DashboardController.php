<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerSession;
use App\Models\TracerSection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

    if (!$user) {
        return redirect()->route('alumni.login');
    }

    $alumni = $user;
        // Ambil session terakhir (draft atau submitted)
        $session = TracerSession::where('alumni_id', $alumni->id)
            ->latest()
            ->first();

        $totalSection = TracerSection::count();

        $currentSection = $session?->current_section ?? 1;
        $status = $session?->status ?? 'not_started';

        // Hitung progress
        if ($status === 'submitted') {
            $progress = 100;
        } elseif ($session) {
            $progress = round((($currentSection - 1) / $totalSection) * 100);
        } else {
            $progress = 0;
        }

        // Aktivitas sederhana (bisa dikembangkan)
        $activities = [];

        if ($session) {
            $activities[] = [
                'tanggal' => $session->started_at,
                'aktivitas' => 'Mulai pengisian Tracer Study',
                'status' => 'Mulai'
            ];

            if ($session->status === 'submitted') {
                $activities[] = [
                    'tanggal' => $session->submitted_at,
                    'aktivitas' => 'Mengirim Tracer Study',
                    'status' => 'Selesai'
                ];
            } else {
                $activities[] = [
                    'tanggal' => now(),
                    'aktivitas' => 'Pengisian sampai Section ' . ($currentSection - 1),
                    'status' => 'Proses'
                ];
            }
        }

        return view('alumni.dashboard', compact(
            'alumni',
            'session',
            'progress',
            'totalSection',
            'currentSection',
            'status',
            'activities'
        ));
    }
}
