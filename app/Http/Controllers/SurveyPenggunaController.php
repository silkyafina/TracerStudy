<?php

namespace App\Http\Controllers;

use App\Models\UserSurvey;
use App\Models\UserSurveyAnswer;
use Illuminate\Http\Request;

class SurveyPenggunaController extends Controller
{
    // =========================
    // TAMPILKAN FORM
    // =========================
    public function show($token)
    {
        $survey = UserSurvey::where('token', $token)->firstOrFail();

        // Jika sudah diisi
        if ($survey->is_filled) {
            return view('survey.sudah_isi');
        }

        $alumni = $survey->alumni;

        return view('survey.form', compact('survey', 'alumni'));
    }

    // =========================
    // SIMPAN JAWABAN
    // =========================
    public function store(Request $request, $token)
    {
        $survey = UserSurvey::where('token', $token)->firstOrFail();

        // Cegah submit ulang
        if ($survey->is_filled) {
            return redirect()
                ->route('survey.pengguna.show', $token)
                ->with('info', 'Survey sudah pernah diisi.');
        }

        // =========================
        // VALIDASI
        // =========================
        $request->validate([
            'integritas' => 'required|integer|min:1|max:5',
            'keahlian' => 'required|integer|min:1|max:5',
            'bahasa_inggris' => 'required|integer|min:1|max:5',
            'teknologi_informasi' => 'required|integer|min:1|max:5',
            'komunikasi' => 'required|integer|min:1|max:5',
            'kerjasama_tim' => 'required|integer|min:1|max:5',
            'pengembangan_diri' => 'required|integer|min:1|max:5',

            'nama_atasan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
            'jabatan_atasan' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'saran' => 'nullable|string',
        ]);

        // =========================
        // SIMPAN DATA
        // =========================
        UserSurveyAnswer::create([
            'user_survey_id' => $survey->id,

            'integritas' => $request->integritas,
            'keahlian' => $request->keahlian,
            'bahasa_inggris' => $request->bahasa_inggris,
            'teknologi_informasi' => $request->teknologi_informasi,
            'komunikasi' => $request->komunikasi,
            'kerjasama_tim' => $request->kerjasama_tim,
            'pengembangan_diri' => $request->pengembangan_diri,

            'nama_atasan' => $request->nama_atasan,
            'nip' => $request->nip,
            'jabatan_atasan' => $request->jabatan_atasan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'saran' => $request->saran,
        ]);

        // Update status survey
        $survey->update([
            'is_filled' => true
        ]);

        return view('survey.terima_kasih');
    }
}