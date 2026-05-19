<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AlumniExport;
use App\Http\Controllers\Controller;
use App\Imports\AlumniImport;
use App\Models\Alumni;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlumniController extends Controller
{
    public function index(Request $request)
{
    $query = Alumni::with('prodi')->orderBy('nama_lengkap');

    // 🔎 SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
              ->orWhere('nim', 'like', '%'.$request->search.'%');
        });
    }

    // 🎓 FILTER PRODI
    if ($request->prodi_id) {
        $query->where('prodi_id', $request->prodi_id);
    }

    // 📅 FILTER TAHUN LULUS RANGE
    if ($request->tahun_dari && $request->tahun_sampai) {

        if ($request->tahun_sampai < $request->tahun_dari) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tahun sampai tidak boleh lebih kecil dari tahun dari');
        }

        $query->whereBetween('tahun_lulus', [
            $request->tahun_dari,
            $request->tahun_sampai
        ]);
    }

    // 📊 FILTER STATUS TRACER
    if ($request->status_tracer == 'sudah') {
        $query->whereHas('tracerSessions');
    }

    if ($request->status_tracer == 'belum') {
        $query->whereDoesntHave('tracerSessions');
    }

    $alumni = $query->paginate(10)->withQueryString();
    $prodi  = Prodi::all();
    $tahun  = range(date('Y'), 2000);

    return view('admin.alumni.index', compact('alumni','prodi','tahun'));
}
    public function show($id)
    {
        $alumni = Alumni::with('prodi')->findOrFail($id);
        return view('admin.alumni.show', compact('alumni'));
    }
    
    public function export(Request $request)
    {
        return Excel::download(
            new AlumniExport($request),
            'data-alumni.xlsx'
        );
    }
    public function create()
    {
    $prodi = Prodi::orderBy('nama_prodi')->get();

    $tahunSekarang = date('Y');
    $tahunLulus = range($tahunSekarang, 2000);

    return view('admin.alumni.create', compact('prodi', 'tahunLulus'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_lengkap'  => 'required|string|max:255',
        'nim'           => 'required|string|max:20|unique:alumni,nim',
        'tanggal_lahir' => 'required|date',
        'nik'           => 'nullable|string|max:20',
        'prodi_id'      => 'required|exists:prodi,id',
        'tahun_lulus'   => 'nullable|integer|min:2000|max:' . date('Y'),
        'no_hp'         => 'nullable|string|max:20',
        'desa'          => 'nullable|string|max:100',
        'kecamatan'     => 'nullable|string|max:100',
        'kota'          => 'nullable|string|max:100',
    ]);

    Alumni::create($request->all());

    return redirect()
        ->route('admin.alumni.index')
        ->with('success', 'Data alumni berhasil ditambahkan');
}


    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);
        $prodi = Prodi::all();
        $tahunSekarang = date('Y');
        $tahunLulus = range($tahunSekarang, 2000);
    
        return view('admin.alumni.edit', compact('alumni', 'prodi', 'tahunLulus'));
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'nim'           => 'required|unique:alumni,nim,' . $id,
            'tanggal_lahir' => 'required|date',
            'nik'           => 'nullable|digits:16',
            'prodi_id' => 'required|exists:prodi,id',
            'tahun_lulus'   => 'nullable|digits:4',
            'no_hp'         => 'nullable|max:15',
        ]);

        $alumni->update($request->all());

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil diperbarui');
    }

    public function destroy($id)
    {
        Alumni::findOrFail($id)->delete();

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil dihapus');
    }

    public function importForm()
{
    return view('admin.alumni.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new AlumniImport, $request->file('file'));

    return redirect()
    ->route('admin.alumni.index')
    ->with('success', 'Data alumni berhasil ditambahkan');
}
public function downloadTemplate()
{
    $file = public_path('template/Template Data Alumni2.xlsx');

    return response()->download($file);
}
}
