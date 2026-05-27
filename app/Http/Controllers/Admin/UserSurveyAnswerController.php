<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserSurveyAnswerExport;
use App\Http\Controllers\Controller;
use App\Imports\UserSurveyAnswerImport;
use Illuminate\Http\Request;
use App\Models\UserSurveyAnswer;
use App\Models\Prodi;
use App\Models\UserSurvey;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class UserSurveyAnswerController extends Controller
{


    public function index(Request $request)
    {
        $query = UserSurvey::with(['alumni.prodi', 'answer']);
    
        // SEARCH
        if ($request->search) {
            $query->whereHas('alumni', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }
    
        // PRODI
        if ($request->prodi_id) {
            $query->whereHas('alumni', function ($q) use ($request) {
                $q->where('prodi_id', $request->prodi_id);
            });
        }
    
        // TAHUN
        if ($request->tahun_dari) {
            $query->whereHas('alumni', function ($q) use ($request) {
                $q->where('tahun_lulus', '>=', $request->tahun_dari);
            });
        }
    
        if ($request->tahun_sampai) {
            $query->whereHas('alumni', function ($q) use ($request) {
                $q->where('tahun_lulus', '<=', $request->tahun_sampai);
            });
        }
    
        $surveys = $query->latest()->paginate(10)->withQueryString();
    
        $prodi = Prodi::orderBy('nama_prodi')->get();
        $tahun = \App\Models\Alumni::select('tahun_lulus')
                    ->distinct()
                    ->orderBy('tahun_lulus')
                    ->pluck('tahun_lulus');
    
        return view('admin.user_survey_answers.index', compact(
            'surveys', 'prodi', 'tahun'
        ));
    }

public function show($id)
{
    $answer = UserSurveyAnswer::with([
        'userSurvey.alumni.prodi'
    ])->findOrFail($id);

    // Hitung rata-rata nilai
    $average = collect([
        $answer->integritas,
        $answer->keahlian,
        $answer->bahasa_inggris,
        $answer->teknologi_informasi,
        $answer->komunikasi,
        $answer->kerjasama_tim,
        $answer->pengembangan_diri,
    ])->avg();

    return view('admin.user_survey_answers.show', compact('answer', 'average'));
}
public function export(Request $request)
{
    return Excel::download(
        new UserSurveyAnswerExport($request),
        'penilaian_pengguna.xlsx'
    );
}
public function importForm()
{
    return view('admin.user_survey_answers.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new UserSurveyAnswerImport, $request->file('file'));

    return redirect()
    ->route('admin.user_survey_answers.index')
    ->with('success', 'Data penilaian pengguna berhasil diimport.');
}
public function downloadTemplate(): BinaryFileResponse
{
    $path = public_path('templates/template_penilaian_pengguna.xlsx');

    return response()->download($path);
}
}