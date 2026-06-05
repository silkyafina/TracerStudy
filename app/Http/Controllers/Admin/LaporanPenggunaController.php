<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanPenggunaExport;
use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Prodi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenggunaController extends Controller
{
    public function index(Request $request)
{
    $tahunList = Alumni::select('tahun_lulus')
        ->distinct()
        ->orderBy('tahun_lulus', 'desc')
        ->pluck('tahun_lulus');

    $prodiList = Prodi::all();

    $jenis = $request->get('jenis', 'jumlah');

    $data = collect();
    $kompetensi = null;

    if ($request->has('jenis')) {

        $result = $this->getData($request);

        if ($jenis == 'jumlah' || $jenis == 'saran') {
            $data = $result;
        } else {
            $kompetensi = $result;
        }
    }

    return view('admin.laporan.pengguna.index', compact(
        'tahunList',
        'prodiList',
        'data',
        'kompetensi',
        'jenis'
    ));
}
private function getData(Request $request)
{
    $jenis = $request->get('jenis', 'jumlah');

    $base = DB::table('alumni as a')
    ->leftJoin('tracer_sessions as ts', function ($join) {
        $join->on('ts.alumni_id', '=', 'a.id')
             ->whereIn('ts.id', function ($q) {
                 $q->select(DB::raw('MAX(id)'))
                   ->from('tracer_sessions')
                   ->groupBy('alumni_id');
             });
    })
        ->leftJoin('tracer_answers as ta', function ($join) {
            $join->on('ta.tracer_session_id', '=', 'ts.id')
                 ->where('ta.tracer_question_id', 9)
                 ->where('ta.value', 1);
        })
        ->leftJoin('user_surveys as us', 'us.alumni_id', '=', 'a.id')
        ->leftJoin('user_survey_answers as usa', 'usa.user_survey_id', '=', 'us.id');

    // FILTER
    if ($request->filled('tahun_dari')) {
        $base->where('a.tahun_lulus', '>=', $request->tahun_dari);
    }

    if ($request->filled('tahun_sampai')) {
        $base->where('a.tahun_lulus', '<=', $request->tahun_sampai);
    }

    if ($request->filled('prodi_id')) {
        $base->where('a.prodi_id', $request->prodi_id);
    }

    if ($request->filled('cari')) {
        $base->where(function ($q) use ($request) {
            $q->where('usa.nama_perusahaan', 'like', '%'.$request->cari.'%')
              ->orWhere('a.nama_lengkap', 'like', '%'.$request->cari.'%');
        });
    }

    // ======================
    // JENIS JUMLAH
    // ======================
    if ($jenis == 'jumlah') {

        return (clone $base)
            ->selectRaw('
                a.tahun_lulus,
                COUNT(DISTINCT CASE WHEN ta.value = 1 THEN a.id END) as alumni_bekerja,
                COUNT(DISTINCT us.alumni_id) as jml_responden
            ')
            ->groupBy('a.tahun_lulus')
            ->orderBy('a.tahun_lulus')
            ->get()
            ->map(function ($row) {
                $row->persentase = $row->alumni_bekerja > 0
                    ? round(($row->jml_responden / $row->alumni_bekerja) * 100, 2)
                    : 0;
                return $row;
            });
    }
    if ($jenis == 'saran') {

        return (clone $base)
            ->select(
                'a.nama_lengkap',
                'a.tahun_lulus',
                'usa.nama_perusahaan',
                'usa.saran'
            )
            ->whereNotNull('usa.saran')
            ->where('usa.saran', '!=', '')
            ->orderByDesc('a.tahun_lulus')
            ->get();
    }
    // ======================
    // JENIS KOMPETENSI
    // ======================
    return (clone $base)
    ->selectRaw('
        AVG(usa.integritas) * 2 as integritas,
        AVG(usa.keahlian) * 2 as keahlian,
        AVG(usa.bahasa_inggris) * 2 as bahasa_inggris,
        AVG(usa.teknologi_informasi) * 2 as teknologi_informasi,
        AVG(usa.komunikasi) * 2 as komunikasi,
        AVG(usa.kerjasama_tim) * 2 as kerjasama_tim,
        AVG(usa.pengembangan_diri) * 2 as pengembangan_diri
    ')
    ->first();
}
public function exportExcel(Request $request)
{
    $jenis = $request->jenis;

    // ambil ulang data pakai logic yang sama
    // (gunakan method private supaya tidak duplikat kalau mau lebih clean)

    $data = $this->getData($request); 

    return Excel::download(
        new LaporanPenggunaExport($data, $jenis),
        'laporan_pengguna.xlsx'
    );
}
private function getKompetensi($request)
{
    $query = DB::table('user_survey_answers as usa')
        ->join('user_surveys as us', 'us.id', '=', 'usa.user_survey_id')
        ->join('alumni as a', 'a.id', '=', 'us.alumni_id');

    // filter tahun
    if ($request->tahun_dari) {
        $query->where('a.tahun_lulus', '>=', $request->tahun_dari);
    }

    if ($request->tahun_sampai) {
        $query->where('a.tahun_lulus', '<=', $request->tahun_sampai);
    }

    if ($request->prodi_id) {
        $query->where('a.prodi_id', $request->prodi_id);
    }

    return $query->selectRaw('
    AVG(usa.integritas) * 2 as integritas,
    AVG(usa.keahlian) * 2 as keahlian,
    AVG(usa.bahasa_inggris) * 2 as bahasa_inggris,
    AVG(usa.teknologi_informasi) * 2 as teknologi_informasi,
    AVG(usa.komunikasi) * 2 as komunikasi,
    AVG(usa.kerjasama_tim) * 2 as kerjasama_tim,
    AVG(usa.pengembangan_diri) * 2 as pengembangan_diri
')->first();
}
public function exportPdf(Request $request)
{
    $jenis = $request->jenis ?? 'jumlah';

    // ======================
    // JUMLAH
    // ======================
    if ($jenis == 'jumlah') {

        $data = $this->getData($request);

        $pdf = Pdf::loadView('admin.laporan.pengguna.pdf', [
            'jenis' => 'jumlah',
            'data' => $data
        ]);
    }

    // ======================
    // SARAN
    // ======================
    elseif ($jenis == 'saran') {

        $data = $this->getData($request);

        $pdf = Pdf::loadView('admin.laporan.pengguna.pdf', [
            'jenis' => 'saran',
            'data' => $data
        ]);
    }

    // ======================
    // KOMPETENSI
    // ======================
    else {

        $kompetensi = $this->getData($request);

        $pdf = Pdf::loadView('admin.laporan.pengguna.pdf', [
            'jenis' => 'kompetensi',
            'kompetensi' => $kompetensi
        ]);
    }

    return $pdf->download('laporan_pengguna.pdf');
}
}