<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\TracerAnswer;
use App\Models\TracerSection;
use App\Models\TracerSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\UserSurvey;
use App\Mail\SurveyPenggunaMail;

use Illuminate\Support\Facades\DB;
class TracerController extends Controller
{
    /* ==========================
     *  HELPER
     * ========================== */
    private function getSession()
    {
        return TracerSession::where('alumni_id', Auth::user()->id)
            ->where('status', 'draft')
            ->firstOrFail();
    }

    private function guardSection(int $urutan)
{
    $alumni = Auth::user();

    $session = TracerSession::where('alumni_id', $alumni->id)
        ->where('status', 'draft')
        ->first();

    if (!$session) {
        return redirect()->route('alumni.dashboard');
    }

    if ($urutan > $session->current_section) {
        return redirect()->route(
            'alumni.tracer.section' . $session->current_section
        );
    }

    return null;
}
    private function renderSection($urutan, $extra = [])
    {
        $redirect = $this->guardSection($urutan);
        if ($redirect instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }

        $section = TracerSection::with([
            'questions.options',
            'questions.items'
        ])->where('urutan', $urutan)->firstOrFail();

        return view("alumni.tracer.section{$urutan}", array_merge([
            'section' => $section,
            'alumni' => Auth::user(),
        ], $extra));
    }
    private function storeSectionTo8(Request $request)
    {
    $session = $this->getSession();

    $answers = $request->input('answers', []);
    $this->saveAnswers($session, $answers);

    $session->update([
        'current_section' => 8
    ]);

    return redirect()->route('alumni.tracer.section8');
    }

    private function alumniProfileComplete($alumni): bool
    {
    return $alumni->nik
        && $alumni->tanggal_lahir
        && $alumni->no_hp
        && $alumni->desa
        && $alumni->kecamatan
        && $alumni->kota;
    }
    private function saveAnswers($session, array $answers)
{
    foreach ($answers as $questionId => $value) {

        // kalau matrix (array)
        if (is_array($value)) {
            $cleanValue = [];

            foreach ($value as $itemId => $score) {
                $cleanValue[$itemId] = $score;
            }

            $value = json_encode($cleanValue);
        }

        TracerAnswer::updateOrCreate(
            [
                'tracer_session_id' => $session->id,
                'tracer_question_id' => $questionId,
            ],
            [
                'value' => is_array($value) ? json_encode($value) : (string) $value,
            ]
        );
    }
}
    /* ==========================
     *  SECTION 1
     * ========================== */

     public function section1()
     {
         $alumni = Auth::guard('alumni')->user();
     
         // cek apakah profil alumni sudah lengkap
         if ($this->alumniProfileComplete($alumni)) {
     
             // pastikan ada tracer session aktif
             TracerSession::firstOrCreate(
                 [
                     'alumni_id' => $alumni->id,
                     'status'    => 'draft',
                 ],
                 [
                     'started_at' => now(),
                     'current_section' => 2
                 ]
             );
     
             return redirect()->route('alumni.tracer.section2');
         }
     
         return view('alumni.tracer.section1', compact('alumni'));
     }
     

    public function storeSection1(Request $request)
    {
        /** @var \App\Models\Alumni $alumni */
        $alumni = Auth::user();

        $request->validate([
            'nik'           => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required',
            'desa'          => 'required',
            'kecamatan'     => 'required',
            'kota'          => 'required',
        ]);

        $session = TracerSession::firstOrCreate(
            [
                'alumni_id' => $alumni->id,
                'status'    => 'draft'
            ],
            [
                'started_at' => now()
            ]
        );
        
        $session->update([
            'current_section' => 2
        ]);
        
        return redirect()->route('alumni.tracer.section2');
    }        

    /* ==========================
     *  SECTION 2
     * ========================== */

    public function section2()
    {
        return $this->renderSection(2);
    }

    public function storeSection2(Request $request)
{
    $session = $this->getSession();
    $answers = $request->input('answers', []);
    $this->saveAnswers($session, $answers);

    $status = (int) ($answers[9] ?? 0);

    if (!$status) {
        return back()->withErrors('Status wajib dipilih');
    }

    switch ($status) {
        case 1: // bekerja
        case 3: // wiraswasta
            $session->update(['current_section' => 3]);
            return redirect()->route('alumni.tracer.section3');

        case 2: // belum memungkinkan
            $session->update(['current_section' => 7]);
            return redirect()->route('alumni.tracer.section7');

        case 4: // studi lanjut
            $session->update(['current_section' => 6]);
            return redirect()->route('alumni.tracer.section6');

        case 5: // cari kerja
            $session->update(['current_section' => 11]);
            return redirect()->route('alumni.tracer.section11');

        default:
            return back()->withErrors('Status tidak valid');
    }
}
    /* ==========================
     *  SECTION 3
     * ========================== */

    public function section3()
    {
        return $this->renderSection(3);
    }

    public function storeSection3(Request $request)
{
    $session = $this->getSession();
    $answers = $request->input('answers', []);
    $this->saveAnswers($session, $answers);

    $jenis = (int) ($answers[10] ?? 0);

    if (!$jenis) {
        return back()->withErrors('Jenis pekerjaan wajib dipilih');
    }

    if ($jenis === 1) {
        $session->update(['current_section' => 4]);
        return redirect()->route('alumni.tracer.section4');
    }

    if ($jenis === 2) {
        $session->update(['current_section' => 5]);
        return redirect()->route('alumni.tracer.section5');
    }

    return back()->withErrors('Pilihan tidak valid');
}
    /* ==========================
     *  SECTION 4–7
     * ========================== */

    public function section4() { return $this->renderSection(4); }
    public function section5() { return $this->renderSection(5); }
    public function section6() { return $this->renderSection(6); }
    public function section7() { return $this->renderSection(7); }

    public function storeSectionGeneric(Request $request, $next)
    {
        $session = $this->getSession();
        $this->saveAnswers($session, $request->input('answers', []));
        $session->update(['current_section' => $next]);
        return redirect()->route("alumni.tracer.section{$next}");
    }
    public function storeSection4(Request $request)
    {
    return $this->storeSectionTo8($request);
    }

    public function storeSection5(Request $request)
    {
        return $this->storeSectionTo8($request);
    }

    public function storeSection6(Request $request)
    {
        return $this->storeSectionTo8($request);
    }

    public function storeSection7(Request $request)
    {
        return $this->storeSectionTo8($request);
    }

    /* ==========================
     *  SECTION 8
     * ========================== */

    public function section8()
    {
        return $this->renderSection(8);
    }

    public function storeSection8(Request $request)
    {
    $session = $this->getSession();
    $answers = $request->input('answers', []);
    $this->saveAnswers($session, $answers);

    $pilihan = (int) ($answers[33] ?? 0);

    if (!$pilihan) {
        return back()->withErrors('Pilihan wajib diisi');
    }

    if ($pilihan === 1) {
        $session->update(['current_section' => 9]);
        return redirect()->route('alumni.tracer.section9');
    }

    if ($pilihan === 2) {
        $session->update(['current_section' => 10]);
        return redirect()->route('alumni.tracer.section10');
    }

    if ($pilihan === 3) {
        $session->update(['current_section' => 11]);
        return redirect()->route('alumni.tracer.section11');
    }

    return back()->withErrors('Pilihan tidak valid');
}


    /* ==========================
     *  SECTION 9–10
     * ========================== */

    public function section9() { return $this->renderSection(9); }
    public function section10() { return $this->renderSection(10); }

    public function storeSectionTo11(Request $request)
    {
        $session = $this->getSession();
        $this->saveAnswers($session, $request->input('answers', []));
        $session->update(['current_section' => 11]);
        return redirect()->route('alumni.tracer.section11');
    }
    public function storeSection9(Request $request)
    {
    return $this->storeSectionTo11($request);
    }
    public function storeSection10(Request $request)
    {
    return $this->storeSectionTo11($request);
    }
    /* ==========================
     *  SECTION 11 (FINAL)
     * ========================== */

    public function section11()
    {
        return $this->renderSection(11);
    }

    public function storeSection11(Request $request)
{
    $session = $this->getSession();

    // Simpan jawaban section terakhir
    $this->saveAnswers($session, $request->input('answers', []));

    // Update status tracer
    $session->update([
        'status'       => 'submitted',
        'submitted_at' => Carbon::now(),
    ]);

    $alumni = $session->alumni;

    // Ambil email pengguna dari jawaban tracer
    $emailPengguna = DB::table('tracer_answers')
        ->where('tracer_session_id', $session->id)
        ->where('tracer_question_id', 21) // GANTI sesuai ID asli pertanyaan email pengguna
        ->value('value');

    if ($emailPengguna) {

        // Cek apakah sudah pernah dibuat survey
        $existingSurvey = UserSurvey::where('alumni_id', $alumni->id)->first();

        if (!$existingSurvey) {

            $userSurvey = UserSurvey::create([
                'alumni_id' => $alumni->id,
                'email'     => $emailPengguna,
            ]);
        
            $link = route('survey.pengguna.show', $userSurvey->token);
        
            Mail::to($emailPengguna)->send(
                new SurveyPenggunaMail($link)
            );
        
        } else {
        
            if (!$existingSurvey->is_filled) {
        
                $link = route('survey.pengguna.show', $existingSurvey->token);
        
                Mail::to($existingSurvey->email)->send(
                    new SurveyPenggunaMail($link)
                );
            }
        }
    }

    return redirect()
        ->route('alumni.dashboard')
        ->with('success', 'Tracer Study berhasil dikirim. Terima kasih!');
}
    public function riwayat()
    {
        $alumni = Auth::user();

    $sessions = TracerSession::where('alumni_id', $alumni->id)
        ->where('status', 'submitted')
        ->orderByDesc('submitted_at')
        ->get();

    return view('alumni.tracer.riwayat', compact('sessions'));
    }
    public function detailRiwayat(TracerSession $session)
    {
    // keamanan: pastikan milik alumni sendiri
    abort_if(
        $session->alumni_id !== Auth::user()->id,
        403
    );

    $session->load([
        'answers.question.section',
        'answers.question.options',
        'answers.question.items'
    ]);

    return view('alumni.tracer.riwayat-detail', compact('session'));
    }

    public function getKota($provinsi_id)
{
    $kota = \App\Models\TracerOption::where('parent_id', $provinsi_id)->get();

    return response()->json($kota);
}
}
