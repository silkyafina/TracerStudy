<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TracerResultExport;
use App\Http\Controllers\Controller;
use App\Imports\TracerImport;
use App\Models\Prodi;
use App\Models\TracerSession;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class TracerResultController extends Controller
{
    
    public function index(Request $request)
{
    $query = TracerSession::query()
        ->select(
            'alumni_id',
            DB::raw('MAX(created_at) as last_filled'),
            DB::raw('COUNT(*) as total_tracer')
        )
        ->with(['alumni.prodi'])
        ->where('status', 'submitted')
        ->groupBy('alumni_id');

    // 🔎 SEARCH nama / NIM
    if ($request->filled('search')) {
        $query->whereHas('alumni', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
              ->orWhere('nim', 'like', '%'.$request->search.'%');
        });
    }

    // 🎓 FILTER PRODI
    if ($request->filled('prodi_id')) {
        $query->whereHas('alumni', function ($q) use ($request) {
            $q->where('prodi_id', $request->prodi_id);
        });
    }

    // 📅 FILTER TAHUN LULUS ALUMNI
if ($request->tahun_dari && $request->tahun_sampai) {

    if ($request->tahun_sampai < $request->tahun_dari) {
        return back()
            ->withInput()
            ->with('error', 'Tahun sampai tidak boleh lebih kecil dari tahun dari');
    }

    $query->whereHas('alumni', function ($q) use ($request) {
        $q->whereBetween('tahun_lulus', [
            $request->tahun_dari,
            $request->tahun_sampai
        ]);
    });
}

    $sessions = $query
        ->orderByDesc('last_filled')
        ->paginate(10)
        ->withQueryString();

    $prodi = Prodi::all();
    $tahun = range(date('Y'), 2000);

    return view('admin.tracer_result.index', compact('sessions','prodi','tahun'));
}

    public function show($alumniId)
    {
        $alumni = \App\Models\Alumni::with('prodi')->findOrFail($alumniId);
    
        $sessions = \App\Models\TracerSession::with([
                'answers.question.section',
                'answers.question.options',
                'answers.question.items',
                'answers.selectedOption'
            ])
            ->where('alumni_id', $alumniId)
            ->orderByDesc('created_at')
            ->get();
    
        return view(
            'admin.tracer_result.show',
            compact('alumni', 'sessions')
        );
    }
    public function edit($id)
    {
        $session = TracerSession::with([
            'answers.question.options',
            'answers.question.items',
            'answers.question.section'
        ])->findOrFail($id);
    
        return view('admin.tracer_result.edit', compact('session'));
    }
    public function update(Request $request, $id)
    {
        $session = TracerSession::with('answers')->findOrFail($id);
    
        foreach ($session->answers as $answer) {
    
            // MATRIX / ITEM
            if (is_array($request->answers[$answer->id] ?? null)) {
    
                $answer->update([
                    'value' => json_encode($request->answers[$answer->id])
                ]);
    
            } else {
    
                $answer->update([
                    'value' => $request->answers[$answer->id]
                ]);
            }
        }
    
        return redirect()
            ->route('admin.tracer.results.show', $session->alumni_id)
            ->with('success', 'Tracer berhasil diperbarui');
    }
public function destroy($id)
{
    $session = TracerSession::findOrFail($id);

    $alumniId = $session->alumni_id;

    $session->delete();

    return redirect()
        ->route('admin.tracer.results.show', $alumniId)
        ->with('success', 'Tracer berhasil dihapus');
}
    public function export(Request $request)
{
    $query = TracerSession::with([
        'alumni.prodi',
        'answers.question.options',
        'answers.question.items'
    ])
    ->where('status', 'submitted');

    // 🔍 SEARCH nama / NIM
    if ($request->filled('search')) {
        $query->whereHas('alumni', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
              ->orWhere('nim', 'like', '%' . $request->search . '%');
        });
    }

    // 🎓 FILTER PRODI
    if ($request->filled('prodi_id')) {
        $query->whereHas('alumni', function ($q) use ($request) {
            $q->where('prodi_id', $request->prodi_id);
        });
    }

    // 📅 FILTER TAHUN
    if ($request->filled('tahun_dari') && $request->filled('tahun_sampai')) {
        if ($request->tahun_sampai < $request->tahun_dari) {
            return back()->with('error', 'Tahun sampai tidak boleh lebih kecil');
        }

        $query->whereYear('submitted_at', '>=', $request->tahun_dari)
              ->whereYear('submitted_at', '<=', $request->tahun_sampai);
    }

    $sessions = $query
    ->whereIn('id', function ($q) {
        $q->select(DB::raw('MAX(id)'))
          ->from('tracer_sessions')
          ->groupBy('alumni_id');
    })
    ->orderByDesc('submitted_at')
    ->get();

    return Excel::download(
        new TracerResultExport($sessions),
        'hasil-tracer-study.xlsx'
    );
    }    
    public function importForm()
    {
        return view('admin.tracer_result.import');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
    
        Excel::import(new TracerImport, $request->file('file'));
    
        return redirect()
        ->route('admin.tracer.results.index')
        ->with('success', 'Data tracer berhasil diupload 🎉');
    }
    public function downloadTemplate()
{
    $file = public_path('template/template_tracer.xlsx');

    return response()->download($file);
}
}
