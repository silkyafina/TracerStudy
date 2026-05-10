<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPenggunaExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $jenis;

    public function __construct($data, $jenis)
    {
        $this->data = $data;
        $this->jenis = $jenis;
    }

    public function collection()
    {
        if ($this->jenis == 'jumlah') {
            return collect($this->data)->map(function ($row) {
                return [
                    $row->tahun_lulus,
                    $row->alumni_bekerja,
                    $row->jml_responden,
                    $row->persentase . '%'
                ];
            });
        }

        return collect([
            ['Integritas', $this->data->integritas],
            ['Keahlian', $this->data->keahlian],
            ['Bahasa Inggris', $this->data->bahasa_inggris],
            ['Teknologi Informasi', $this->data->teknologi_informasi],
            ['Komunikasi', $this->data->komunikasi],
            ['Kerjasama Tim', $this->data->kerjasama_tim],
            ['Pengembangan Diri', $this->data->pengembangan_diri],
        ]);
    }

    public function headings(): array
    {
        if ($this->jenis == 'jumlah') {
            return [
                'Tahun Lulus',
                'Jml Alumni Bekerja',
                'Jml Responden',
                'Persentase'
            ];
        }

        return ['Kompetensi', 'Nilai'];
    }
}