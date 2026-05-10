<?php

namespace App\Http\Controllers\Admin;


use App\Exports\LaporanViewExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi;
use App\Models\TracerQuestion;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    public function index(Request $request)
{
    // =========================
    // DROPDOWN
    // =========================
    $tahun = DB::table('alumni')
        ->select('tahun_lulus')
        ->distinct()
        ->orderBy('tahun_lulus', 'desc')
        ->pluck('tahun_lulus');

    $prodi = Prodi::orderBy('nama_prodi')->get();

    $allowedQuestionIds = [9, 3, 7, 8, 18, 22, 23, 26, 27, 42, 43, 51];

    $pertanyaan = TracerQuestion::whereIn('id', $allowedQuestionIds)
        ->orderBy('urutan')
        ->get();

    // =========================
    // DEFAULT
    // =========================
    $matrixTable = [];
    $table = [];
    $categories = collect();
    $judulLaporan = '';
    $question = null;
    $isMatrix = false;

    // =========================
    // BELUM PILIH
    // =========================
    if (!$request->filled('tracer_question_id')) {
        return view('admin.laporan.index', compact(
            'tahun',
            'prodi',
            'pertanyaan',
            'isMatrix',
            'matrixTable',
            'table',
            'categories',
            'judulLaporan',
            'question'
        ));
    }

    // =========================
    // AMBIL PERTANYAAN
    // =========================
    $question = TracerQuestion::with('items')
        ->findOrFail($request->tracer_question_id);

    $judulLaporan = $question->label_pertanyaan;

    // =========================
    // CEK MATRIX
    // =========================
    $isMatrix = $question->items->count() > 0;

    // =====================================================
    // 🔷 KHUSUS RANGE MASA TUNGGU
    // =====================================================
    if ($question->id == 42) {

        $result = $this->getRangeMasaTunggu($request, $question);

        $table = $result['table'];
        $categories = $result['categories'];

    }
    // =====================================================
    // 🔷 MATRIX
    // =====================================================
    elseif ($isMatrix) {

        $result = $this->getMatrixReport($request, $question);

        $matrixTable = $result['table'];
        $categories  = $result['headers'];

    }
    // =====================================================
    // 🔷 RADIO / SELECT
    // =====================================================
    else {

        $raw = $this->getDataLaporan($request);

        $years      = $raw->pluck('tahun_lulus')->unique()->sort()->values();
        $categories = $raw->pluck('kategori')->unique()->values();

        foreach ($years as $year) {

            $row = [
                'tahun' => $year,
                'total' => 0
            ];

            foreach ($categories as $cat) {

                $jumlah = $raw
                    ->where('tahun_lulus', $year)
                    ->where('kategori', $cat)
                    ->sum('total');

                $row[$cat] = $jumlah;
                $row['total'] += $jumlah;
            }

            $table[] = $row;
        }
    }

    return view('admin.laporan.index', compact(
        'tahun',
        'prodi',
        'pertanyaan',
        'isMatrix',
        'matrixTable',
        'table',
        'categories',
        'judulLaporan',
        'question'
    ));
}
private function getRangeMasaTunggu(Request $request, $question)
{
    $query = DB::table('tracer_answers as ta')
        ->join('tracer_sessions as ts', 'ts.id', '=', 'ta.tracer_session_id')
        ->join('alumni as a', 'a.id', '=', 'ts.alumni_id')

        // ambil session terakhir
        ->whereIn('ts.id', function ($q) {
            $q->select(DB::raw('MAX(id)'))
              ->from('tracer_sessions')
              ->groupBy('alumni_id');
        })

        ->where('ta.tracer_question_id', $question->id)
        ->whereNotNull('ta.value');

    // ================= FILTER =================
    if ($request->tahun_dari) {
        $query->where('a.tahun_lulus', '>=', $request->tahun_dari);
    }

    if ($request->tahun_sampai) {
        $query->where('a.tahun_lulus', '<=', $request->tahun_sampai);
    }

    if ($request->prodi_id) {
        $query->where('a.prodi_id', $request->prodi_id);
    }
    if ($request->kategori) {

        $kategoriArray = explode(',', $request->kategori);
    
        $query->whereExists(function ($sub) use ($kategoriArray) {
    
            $sub->select(DB::raw(1))
                ->from('tracer_answers as ta_status')
                ->join('tracer_sessions as ts_status', 'ts_status.id', '=', 'ta_status.tracer_session_id')
    
                // alumni yang sama
                ->whereColumn('ts_status.alumni_id', 'a.id')
    
                // pertanyaan status alumni
                ->where('ta_status.tracer_question_id', 9)
    
                // status yang dipilih
                ->whereIn('ta_status.value', $kategoriArray)
    
                // hanya session terakhir
                ->whereIn('ts_status.id', function ($q) {
                    $q->select(DB::raw('MAX(id)'))
                      ->from('tracer_sessions')
                      ->groupBy('alumni_id');
                });
        });
    }
    $answers = $query
        ->select('a.tahun_lulus', 'ta.value')
        ->get();

    // ================= RANGE =================
    $ranges = [
        '≤ 3 bulan' => 0,
        '3 - 6 bulan' => 0,
        '> 6 bulan' => 0,
    ];

    $data = [];

    foreach ($answers as $ans) {

        $year = $ans->tahun_lulus;
    
        $raw = $ans->value;
        $decoded = json_decode($raw, true);
    
        if (is_array($decoded)) {
            $val = (int) (array_values($decoded)[0] ?? 0);
        } else {
            $val = (int) $raw;
        }
    
        if ($val <= 3) {
            $label = '≤ 3 bulan';
        } elseif ($val <= 6) {
            $label = '3 - 6 bulan';
        } else {
            $label = '> 6 bulan';
        }
    
        $data[$year][$label] = ($data[$year][$label] ?? 0) + 1;
    }
    // ================= FORMAT TABLE =================
    $table = [];

    foreach ($data as $year => $vals) {

        $row = [
            'tahun' => $year,
            'total' => array_sum($vals)
        ];
    
        foreach ($ranges as $label => $v) {
            $row[$label] = $vals[$label] ?? 0;
        }
    
        $table[] = $row;
    }

    return [
        'table' => $table,
        'categories' => collect(array_keys($ranges))
    ];
}
private function getDataLaporan(Request $request)
{
    $questionId = $request->tracer_question_id;

    $query = DB::table('tracer_sessions as ts')
        ->join('alumni as a', 'a.id', '=', 'ts.alumni_id')
        ->join('tracer_answers as ta', 'ta.tracer_session_id', '=', 'ts.id')
        ->join('tracer_options as o', function ($join) use ($questionId) {
            $join->on('ta.value', '=', 'o.value')
                 ->where('o.tracer_question_id', '=', $questionId);
        })

        // 🔹 ambil session terakhir per alumni
        ->whereIn('ts.id', function ($q) {
            $q->select(DB::raw('MAX(id)'))
              ->from('tracer_sessions')
              ->groupBy('alumni_id');
        })

        ->where('ta.tracer_question_id', $questionId)
        ->whereNotNull('ta.value');

    /*
    =====================================================
    🔵 FILTER STATUS (Pertanyaan ID = 9)
    =====================================================
    */
    if ($request->kategori) {

        $kategoriArray = explode(',', $request->kategori);
    
        $query->whereExists(function ($sub) use ($kategoriArray) {
    
            $sub->select(DB::raw(1))
                ->from('tracer_answers as ta_status')
                ->join('tracer_sessions as ts_status', 'ts_status.id', '=', 'ta_status.tracer_session_id')
    
                ->whereColumn('ts_status.alumni_id', 'a.id')
                ->where('ta_status.tracer_question_id', 9)
    
                ->whereIn('ta_status.value', $kategoriArray)
    
                ->whereIn('ts_status.id', function ($q) {
                    $q->select(DB::raw('MAX(id)'))
                      ->from('tracer_sessions')
                      ->groupBy('alumni_id');
                });
        });
    }

    /*
    =====================================================
    🔵 FILTER TAHUN
    =====================================================
    */
    if ($request->tahun_dari) {
        $query->where('a.tahun_lulus', '>=', $request->tahun_dari);
    }

    if ($request->tahun_sampai) {
        $query->where('a.tahun_lulus', '<=', $request->tahun_sampai);
    }

    /*
    =====================================================
    🔵 FILTER PRODI
    =====================================================
    */
    if ($request->prodi_id) {
        $query->where('a.prodi_id', $request->prodi_id);
    }
    /*
    =====================================================
    🔵 SELECT & GROUP
    =====================================================
    */
    return $query
        ->select(
            'a.tahun_lulus',
            'o.label as kategori',
            DB::raw('COUNT(DISTINCT a.id) as total')
        )
        ->groupBy('a.tahun_lulus', 'o.label')
        ->orderBy('a.tahun_lulus')
        ->orderByDesc('total')
        ->get();
}
private function getMatrixReport(Request $request, $question)
{
    $items = $question->items;

    $query = DB::table('tracer_answers as ta')
        ->join('tracer_sessions as ts', 'ts.id', '=', 'ta.tracer_session_id')
        ->join('alumni as a', 'a.id', '=', 'ts.alumni_id')

        // session terakhir
        ->whereIn('ts.id', function ($q) {
            $q->select(DB::raw('MAX(id)'))
              ->from('tracer_sessions')
              ->groupBy('alumni_id');
        })

        ->where('ta.tracer_question_id', $question->id)
        ->whereNotNull('ta.value');

    /*
    ===============================
    FILTER STATUS (ID 9)
    ===============================
    */
    if ($request->kategori) {
        $query->whereExists(function ($sub) use ($request) {
            $sub->select(DB::raw(1))
                ->from('tracer_answers as ta_status')
                ->join('tracer_sessions as ts_status', 'ts_status.id', '=', 'ta_status.tracer_session_id')
                ->whereColumn('ts_status.alumni_id', 'a.id')
                ->where('ta_status.tracer_question_id', 9)
                ->where('ta_status.value', $request->kategori)
                ->whereIn('ts_status.id', function ($q) {
                    $q->select(DB::raw('MAX(id)'))
                      ->from('tracer_sessions')
                      ->groupBy('alumni_id');
                });
        });
    }

    if ($request->tahun_dari) {
        $query->where('a.tahun_lulus', '>=', $request->tahun_dari);
    }

    if ($request->tahun_sampai) {
        $query->where('a.tahun_lulus', '<=', $request->tahun_sampai);
    }

    if ($request->prodi_id) {
        $query->where('a.prodi_id', $request->prodi_id);
    }

    $answers = $query->select('a.id as alumni_id', 'a.tahun_lulus', 'ta.value')
        ->get();

    $matrix = [];
    $maxScore = 5;

    foreach ($answers as $ans) {
        $decoded = json_decode($ans->value, true);
        $year = $ans->tahun_lulus;
    
        foreach ($items as $item) {
            $key = (string) $item->id; // cast ke string
    
            if (!isset($decoded[$key])) continue; // ← pakai $key
    
            $matrix[$year][$item->label]['sum'] =
                ($matrix[$year][$item->label]['sum'] ?? 0)
                + (int) $decoded[$key]; // ← pakai $key, cast ke int
    
            $matrix[$year][$item->label]['count'] =
                ($matrix[$year][$item->label]['count'] ?? 0) + 1;
        }
    }

    $table = [];

    foreach ($matrix as $year => $itemsData) {
        $row = ['tahun' => $year];

        foreach ($itemsData as $label => $data) {
            $row[$label] = round(
                ($data['sum'] / ($data['count'] * $maxScore)) * 100,
                2
            );
        }

        $table[] = $row;
    }

    return [
        'table'   => $table,
        'headers' => $items->pluck('label')->values()
    ];
}
public function exportExcel(Request $request)
{
    $question = TracerQuestion::with(['options', 'items'])
        ->findOrFail($request->tracer_question_id);

    $isMatrix = $question->items->count() > 0;

    // 🔥 SAMAKAN DENGAN INDEX()
    if ($question->id == 42) {

        $result = $this->getRangeMasaTunggu($request, $question);
        $table = $result['table'];
        $categories = $result['categories'];

    } elseif ($isMatrix) {

        $result = $this->getMatrixReport($request, $question);
        $table = $result['table'];
        $categories = $result['headers'];

    } else {

        $raw = $this->getDataLaporan($request);

        $years      = $raw->pluck('tahun_lulus')->unique()->sort()->values();
        $categories = $raw->pluck('kategori')->unique()->values();
        $table      = [];

        foreach ($years as $year) {

            $row = ['tahun' => $year, 'total' => 0];

            foreach ($categories as $cat) {

                $jumlah = $raw
                    ->where('tahun_lulus', $year)
                    ->where('kategori', $cat)
                    ->sum('total');

                $row[$cat] = $jumlah;
                $row['total'] += $jumlah;
            }

            $table[] = $row;
        }

        $table = $this->appendGrandTotal($table, $categories);
    }

    return Excel::download(
        new LaporanViewExport($table, $categories, $isMatrix),
        'Laporan.xlsx'
    );
}
private function appendGrandTotal($table, $categories)
{
    if ($categories instanceof \Illuminate\Support\Collection) {
        $keys = $categories->values()->toArray(); // ✅ ambil values bukan keys
    } else {
        $keys = array_values($categories); // ✅ sama, pakai values
    }

    $grandTotal = [
        'tahun' => 'Total',
        'total' => 0,
        'percent' => []
    ];

    foreach ($keys as $key) {
        $grandTotal[$key] = 0;
    }

    foreach ($table as $row) {
        foreach ($keys as $key) {
            $grandTotal[$key] += $row[$key] ?? 0;
        }
        $grandTotal['total'] += $row['total'] ?? 0;
    }

    foreach ($keys as $key) {
        $grandTotal['percent'][$key] =
            $grandTotal['total'] > 0
            ? round(($grandTotal[$key] / $grandTotal['total']) * 100) . '%'
            : '0%';
    }

    $table[] = $grandTotal;

    return $table;
}
public function exportPdf(Request $request)
{
    $question = TracerQuestion::with(['options', 'items'])
        ->findOrFail($request->tracer_question_id);

    $isMatrix = $question->items->count() > 0;

    $table = [];
    $categories = collect();

    // ✅ RANGE
    if ($question->id == 42) {

        $result = $this->getRangeMasaTunggu($request, $question);

        $table = $result['table'];
        $categories = $result['categories'];
        $isMatrix = false;

    }
    // ✅ MATRIX
    elseif ($isMatrix) {

        $result = $this->getMatrixReport($request, $question);

        $table = $result['table'];
        $categories = $result['headers'];

    }
    // ✅ RADIO
    else {

        $raw = $this->getDataLaporan($request);

        $years      = $raw->pluck('tahun_lulus')->unique()->sort()->values();
        $categories = $raw->pluck('kategori')->unique()->values();

        foreach ($years as $year) {

            $row = [
                'tahun' => $year,
                'total' => 0
            ];

            foreach ($categories as $cat) {

                $jumlah = $raw
                    ->where('tahun_lulus', $year)
                    ->where('kategori', $cat)
                    ->sum('total');

                $row[$cat] = $jumlah;
                $row['total'] += $jumlah;
            }

            $table[] = $row;
        }

        $table = $this->appendGrandTotal($table, $categories);
    }

    $pdf = Pdf::loadView('admin.laporan.export.pdf', [
        'question'   => $question,
        'table'      => $table,
        'categories' => $categories,
        'isMatrix'   => $isMatrix,
    ])->setPaper('A4', 'landscape');

    return $pdf->download('Laporan_Tracer_Study_' . date('Y-m-d') . '.pdf');
}
}