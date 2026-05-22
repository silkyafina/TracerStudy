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
        return $this->data->map(function ($row) {

            return [
                'Program Studi' => $row['nama_prodi'],
                'Jumlah Alumni' => $row['jumlah_alumni'],
                'Jumlah Responden' => $row['jumlah_responden'],
                'Persentase' => $row['persentase'] . '%',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'Jumlah Alumni',
            'Jumlah Responden',
            'Persentase'
        ];
    }
}