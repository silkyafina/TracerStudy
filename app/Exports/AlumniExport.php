<?php

namespace App\Exports;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Alumni::with('prodi');

        if ($this->request->search) {
            $query->where(function($q){
                $q->where('nama_lengkap','like','%'.$this->request->search.'%')
                  ->orWhere('nim','like','%'.$this->request->search.'%');
            });
        }

        if ($this->request->prodi_id) {
            $query->where('prodi_id',$this->request->prodi_id);
        }

        if ($this->request->tahun_dari && $this->request->tahun_sampai) {
            $query->whereBetween('tahun_lulus', [
                $this->request->tahun_dari,
                $this->request->tahun_sampai
            ]);
        }
        // 📊 STATUS TRACER
        if ($this->request->status_tracer == 'sudah') {
            $query->whereHas('tracerSessions');
        }

        if ($this->request->status_tracer == 'belum') {
            $query->whereDoesntHave('tracerSessions');
        }
      

        return $query->get()->map(function($a){
            return [
                'NIM'         => $a->nim,
                'Nama'        => $a->nama_lengkap,
                'Tanggal Lahir' => $a->tanggal_lahir,
                'NIK' => ' ' . $a->nik,
                'Prodi'       => $a->prodi->nama_prodi ?? '-',
                'Tahun Lulus' => $a->tahun_lulus,
                'No HP'       => $a->no_hp,
                'Desa'        => $a->desa,
                'Kecamatan'   => $a->kecamatan,
                'Kota' => $a->kota,
                $a->tracerSessions->count() > 0 ? 'Sudah' : 'Belum',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Tanggal Lahir',
            'NIK',
            'Program Studi',
            'Tahun Lulus',
            'No HP',
            'Desa',
            'Kecamatan',
            'Kota',
            'Status Tracer'
        ];
    }
}
