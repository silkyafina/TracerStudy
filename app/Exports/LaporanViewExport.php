<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanViewExport implements FromView
{
    protected $table;
    protected $categories;
    protected $isMatrix;

    public function __construct($table, $categories, $isMatrix)
    {
        $this->table = $table;
        $this->categories = $categories;
        $this->isMatrix = $isMatrix;
    }

    public function view(): View
    {
        return view('admin.laporan.export.excel', [
            'table' => $this->table,
            'categories' => $this->categories,
            'isMatrix' => $this->isMatrix
        ]);
    }
}
