<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardRekapExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = $this->data->map(function ($row) {

            return [
                'Program Studi'     => $row['nama_prodi'],
                'Jumlah Alumni'     => $row['jumlah_alumni'],
                'Jumlah Responden'  => $row['jumlah_responden'],
                'Persentase'        => number_format($row['persentase'], 2) . '%',
            ];
        });

        $totalAlumni = $this->data->sum('jumlah_alumni');

        $totalResponden = $this->data->sum('jumlah_responden');

        $persentaseTotal = $totalAlumni > 0
            ? round(($totalResponden / $totalAlumni) * 100, 2)
            : 0;

        $rows->push([
            'Program Studi'     => 'TOTAL',
            'Jumlah Alumni'     => $totalAlumni,
            'Jumlah Responden'  => $totalResponden,
            'Persentase'        => number_format($persentaseTotal, 2) . '%',
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'Jumlah Alumni',
            'Jumlah Responden',
            'Persentase',
        ];
    }
}