<?php

namespace App\Exports;

use App\Models\TracerSection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TracerResultExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $sessions;
    protected $sections;

    public function __construct($sessions)
    {
        $this->sessions = $sessions;

        $this->sections = TracerSection::with([
            'questions' => function ($q) {
                $q->orderBy('urutan')
                ->with([
    'items' => function ($i) {
        $i->orderBy('urutan');
    },
    'options'
]);
            }
        ])->orderBy('urutan')->get();
    }

    public function headings(): array
{
    $headings = [
        'Nama Lengkap',
        'NIM',
        'Tanggal Lahir',
        'NIK',
        'Program Studi',
        'Tahun Lulus',
        'No HP',
        'Desa',
        'Kecamatan',
        'Kota',
    ];

    foreach ($this->sections as $section) {
        foreach ($section->questions as $q) {

            $text = strip_tags($q->pertanyaan);

            // MATRIX
            if ($q->tipe_jawaban === 'matrix_likert') {
                foreach ($q->items as $item) {
                    $headings[] = $text . ' - ' . $item->label;
                }
            }

            // CHECKBOX SAJA
            elseif ($q->tipe_jawaban === 'checkbox') {
                foreach ($q->options as $opt) {
                    $headings[] = $text . ' - ' . $opt->label;
                }
            }

            // RADIO / SELECT / TEXT
            else {
                $headings[] = $text;
            }
        }
    }

    return $headings;
}

public function collection()
{
    return $this->sessions->map(function ($session) {

        $row = [
            'Nama Lengkap'     => $session->alumni->nama_lengkap,
            'NIM'              => $session->alumni->nim,
            'Tanggal Lahir'    => $session->alumni->tanggal_lahir,
            'NIK' => ' ' . $session->alumni->nik,
            'Program Studi'    => $session->alumni->prodi->nama_prodi ?? '',
            'Tahun Lulus'      => $session->alumni->tahun_lulus,
            'No HP'            => $session->alumni->no_hp,
            'Desa'             => $session->alumni->desa,
            'Kecamatan'        => $session->alumni->kecamatan,
            'Kota / Kabupaten' => $session->alumni->kota,
        ];

        foreach ($this->sections as $section) {
            foreach ($section->questions as $q) {

                $questionText = strip_tags($q->pertanyaan);

                $answer = $session->answers
                    ->where('tracer_question_id', $q->id)
                    ->first();

               

                /**
                 * =========================
                 * MATRIX
                 * =========================
                 */
                if (strtolower($q->tipe_jawaban) === 'matrix_likert') {

                    if (!$answer) {
                        foreach ($q->items as $item) {
                            $row[$questionText . ' - ' . $item->label] = '';
                        }
                        continue;
                    }
                
                    $decoded = json_decode($answer->value, true);
                    $decoded = is_array($decoded) ? $decoded : [];
                
                    foreach ($q->items as $item) {
                
                        // karena key = item_id (SUDAH SESUAI)
                        $value = $decoded[$item->id] ?? '';
                
                        $row[$questionText . ' - ' . $item->label] = $value;
                    }
                }
                

                /**
                 * =========================
                 * CHECKBOX
                 * =========================
                 */
                elseif ($q->tipe_jawaban === 'checkbox') {

                    // kalau tidak ada jawaban → semua 0
                    if (!$answer) {
                        foreach ($q->options as $opt) {
                            $row[$questionText . ' - ' . $opt->label] = 0;
                        }
                        continue;
                    }
                
                    // decode sekali saja
                    $decoded = json_decode($answer->value, true);
                
                    // pastikan selalu array
                    if (is_array($decoded)) {
                        $selected = $decoded;
                    } elseif (!is_null($decoded)) {
                        // kalau cuma 1 value (string / angka)
                        $selected = [$decoded];
                    } else {
                        $selected = [];
                    }
                
                    // samakan tipe data (hindari "1" vs 1 beda)
                    $selected = array_map('strval', $selected);
                
                    foreach ($q->options as $opt) {
                
                        $row[$questionText . ' - ' . $opt->label] =
                            in_array((string)$opt->value, $selected)
                            ? 1
                            : 0;
                    }
                }

                /**
                 * =========================
                 * RADIO / SELECT / TEXT
                 * =========================
                 */
                else {

                    if (!$answer) {
                        $row[$questionText] = '';
                        continue;
                    }
                
                    $displayValue = $answer->value;
                
                    $option = $q->options
                        ->where('id', $answer->value)
                        ->first();
                
                    if ($option) {
                        $displayValue = $option->value;
                    }
                
                    $row[$questionText] = $displayValue;
                }
            }
        }

        return collect($row);
    });
}

    
}
