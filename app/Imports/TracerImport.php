<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Alumni;
use App\Models\TracerSession;
use App\Models\TracerAnswer;
use App\Models\TracerOption;
use App\Models\TracerQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TracerImport implements ToCollection, WithHeadingRow
{
    private function normalize($text)
{
    $text = strtolower($text);

    // hapus simbol
    $text = str_replace(['?', '/', '-', ',', '(', ')', ';', '.'], '', $text);

    // ubah spasi jadi underscore dulu
    $text = str_replace(' ', '_', $text);

    // baru rapikan underscore ganda
    $text = preg_replace('/_+/', '_', $text);

    return trim($text, '_');
}
    public function collection(Collection $rows)
    {
        
        // 🔥 ambil semua pertanyaan dari DB
        $options = TracerOption::all()->groupBy('tracer_question_id');
        $questions = TracerQuestion::all();
        $map = [
            "sebutkan_sumber_dana_dalam_pembiayaan_kuliah_di_universitas_harkat_negeri" => 1,
            "jelaskan_status_anda_saat_ini" => 9,
            "status_anda_saat_ini_bekerja_berwiraswasta" => 10,
            "dalam_berapa_bulan_setelah_lulus_anda_mendapatkan_pekerjaan_pertama_mulai_berwiraswasta" => 42,
            "akumulasi_keseluruhan_penghasilan_termasuk_gaji_pokok_uang_makan_transport_dan_tunjangan_lainnya_dalam_satuan_rupiah" => 43,
            "dimana_lokasi_provinsi_tempat_anda_bekerja" => 47,
            "dimana_lokasi_kabupatenkota_tempat_anda_bekerja" => 48,
            "alamat_lengkap_perusahaankantor_tempat_anda_bekerja" => 49,
            "apa_nama_perusahaankantor_tempat_anda_bekerja" => 50,
            "apa_tingkat_tempat_kerja_anda" => 51,
            "apa_jenis_perusahaan_instansiinstitusi_tempat_anda_bekerja_sekarang" => 18,
            "nama_atasan_langsung_pimpinan_tempat_kerja" => 19,
            "no_hp_wa_atasan_langsung_pimpinan_tempat_kerja" => 20,
            "email_atasan_langsung_pimpinan_tempat_kerja" => 21,
            "seberapa_erat_hubungan_bidang_studi_dengan_pekerjaan_anda" => 22,
            "tingkat_pendidikan_apa_yang_paling_tepatatau_sesuai_untuk_pekerjaan_anda_saat_ini" => 23,
            "apa_posisi_jabatan_anda_saat_ini" => 26,
            "sumber_biaya_studi_lanjut" => 27,
            "nama_perguruan_tinggi" => 28,
            "program_studi_lanjut" => 29,
            "tanggal_masuk" => 30,
            "alamat_perguruan_tinggi" => 31,
            "kenapa_anda_belum_memungkinkan_bekerja" => 32,
            "kapan_anda_mulai_mencari_pekerjaan_f301" => 33,
            "berapa_bulan_sebelum_lulus_anda_mulai_mencari_pekerjaan" => 34,
            "berapa_bulan_setelah_lulus_anda_mulai_mencari_pekerjaan" => 35,
            "bagaimana_anda_mencari_pekerjaan" => 36,
            "berapa_banyak_perusahaaninstansiinstitusi_yang_sudah_anda_lamar_lewat_surat_atau_email_sebelum_anda_memperoleh_pekerjaan_pertama" => 37,
            "berapa_banyak_perusahaaninstansiinstitusi_yang_merespon_lamaran_anda" => 38,
            "berapa_banyak_perusahaaninstansiinstitusi_yang_mengundang_anda_untuk_wawancara" => 39,
            "apakah_anda_aktif_mencari_pekerjaan_dalam_4_minggu_terakhir" => 40,
            "jika_menurut_anda_pekerjaan_anda_saat_ini_tidak_sesuai_dengan_pendidikan_anda_mengapa_anda_mengambilnya" => 41,
        ];

        $matrixMap = [
            3 => 'pada_saat_lulus_pada_tingkat_mana_kompetensi',
            7 => 'pada_saat_ini_pada_tingkat_mana_kompetensi',
            8 => 'menurut_anda_seberapa_besar_penekanan_pada_metode_pembelajaran',
        ];
        $itemMap = [
            3 => [ // untuk question_id 3
                'etika' => 1,
                'keahlian_berdasarkan_bidang_ilmu' => 2,
                'bahasa_inggris' => 3,
                'penggunaan_teknologi_informasi' => 4,
                'komunikasi' => 5,
                'kerja_sama_tim' => 6,
                'pengembangan' => 7,
            ],
            7 => [ // untuk question_id 7
                'etika' => 8,
                'keahlian_berdasarkan_bidang_ilmu' => 9,
                'bahasa_inggris' => 10,
                'penggunaan_teknologi_informasi' => 11,
                'komunikasi' => 12,
                'kerja_sama_tim' => 13,
                'pengembangan' => 14,
            ],
            8 => [ // metode pembelajaran
                'perkuliahan' => 15,
                'demonstrasi' => 16,
                'partisipasi_dalam_proyek_riset' => 17,
                'magang' => 18,
                'praktikum' => 19,
                'kerja_lapangan' => 20,
                'diskusi'=>21
            ]
        ];
        $checkboxMap = [
            36 => [
                'melalui_iklan_di_koranmajalah_brosur' => 1,
                'melamar_ke_perusahaan_tanpa_mengetahui_lowongan_yang_ada' => 2,
                'pergi_ke_bursa_pameran_kerja' => 3,
                'mencari_lewat_internetiklan_onlinemilis' => 4,
                'dihubungi_oleh_perusahaan' => 5,
                'menghubungi_kemenakertrans' => 6,
                'menghubungi_agen_tenaga_kerja_komersialswasta' => 7,
                'memperoleh_informasi_dari_pusatkantor_pengembangan_karir_fakultasuniversitas' => 8,
                'menghubungi_kantor_kemahasiswaanhubungan_alumni' => 9,
                'membangun_jejaringnetwork_sejak_masih_kuliah' => 10,
                'melalui_relasi_misalnya_dosen_orang_tua_saudara_teman_dll' => 11,
                'membangun_bisnis_sendiri' => 12,
                'melalui_penempatan_kerja_atau_magang' => 13,
                'bekerja_di_tempat_yang_sama_dengan_tempat_kerja_semasa_kuliah' => 14,
            ],
            41 => [
                'pertanyaan_tidak_sesuai_pekerjaan_saya_sekarang_sudah_sesuai_dengan_pendidikan_saya' => 1,
                'saya_belum_mendapatkan_pekerjaan_yang_lebih_sesuai' => 2,
                'di_pekerjaan_ini_saya_memeroleh_prospek_karir_yang_baik' => 3,
                'saya_lebih_suka_bekerja_di_area_pekerjaan_yang_tidak_ada_hubungannya_dengan_pendidikan_saya' => 4,
                'saya_dipromosikan_ke_posisi_yang_kurang_berhubungan_dengan_pendidikan_saya_dibanding_posisi_sebelumnya' => 5,
                'saya_dapat_memeroleh_pendapatan_yang_lebih_tinggi_di_pekerjaan_ini' => 6,
                'pekerjaan_saya_saat_ini_lebih_amanterjaminsecure' => 7,
                'pekerjaan_saya_saat_ini_lebih_menarik' => 8,
                'pekerjaan_saya_saat_ini_lebih_memungkinkan_saya_mengambil_pekerjaan_tambahanjadwal_yang_fleksibel_dll' => 9,
                'pekerjaan_saya_saat_ini_lokasinya_lebih_dekat_dari_rumah_saya' => 10,
                'pekerjaan_saya_saat_ini_dapat_lebih_menjamin_kebutuhan_keluarga_saya' => 11,
                'pada_awal_meniti_karir_ini_saya_harus_menerima_pekerjaan_yang_tidak_berhubungan_dengan_pendidikan_saya' => 12,
            ],
        ];
         foreach ($rows as $row) {

        $row = $row->toArray();
        // 🔥 INIT MATRIX DI SINI (WAJIB)
        $matrixData = [];
        $checkboxData = [];

        // 1️⃣ cari alumni
        $alumni = Alumni::where('nim', $row['nim'])->first();
        if (!$alumni) continue;

        // 2️⃣ buat session
        $session = TracerSession::create([
            'alumni_id' => $alumni->id,
            'status' => 'submitted',
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        // 3️⃣ LOOP KOLOM
        foreach ($row as $col => $value) {
            $col = $this->normalize($col);
            if ($value === null || $value === '') continue;
            
            // 🔥 HANDLE MATRIX
            foreach ($matrixMap as $qid => $keyword) {

                if (str_contains($col, $keyword)) {

                    foreach ($itemMap[$qid] as $item => $no) {

                        if (str_contains($col, $item)) {
                            $matrixData[$qid][$no] = (string)$value;
                        }
                    }
                }
            }
            foreach ($checkboxMap as $qid => $items) {

                foreach ($items as $label => $no) {
            
                    if (str_contains($col, $label) && $value == 1) {
                        $option = TracerOption::where('tracer_question_id', $qid)
                        ->where('label', $label)
                        ->first();
                        if ($option) {
                            $checkboxData[$qid][] = $option->id;
                        }
                    }
                }
            }
            // 🔥 HANDLE NON MATRIX
            if (isset($map[$col])) {

                $qid = $map[$col];
                if ($col === 'tanggal_masuk' && is_numeric($value)) {
                    $value = Date::excelToDateTimeObject($value)
                                ->format('d F Y');
                }
                $finalValue = (string) $value;
                
                // cek apakah question punya options
                $finalValue = (string) $value;
                
                TracerAnswer::create([
                    'tracer_session_id'  => $session->id,
                    'tracer_question_id' => $qid,
                    'value'              => (string) $finalValue,
                ]);
            }
        }

        // 🔥 SIMPAN MATRIX SEKALI PER PERTANYAAN
        foreach ($matrixData as $qid => $data) {

            TracerAnswer::create([
                'tracer_session_id'  => $session->id,
                'tracer_question_id' => $qid,
                'value'              => json_encode($data),
            ]);
        }
        foreach ($checkboxData as $qid => $values) {

            TracerAnswer::create([
                'tracer_session_id'  => $session->id,
                'tracer_question_id' => $qid,
                'value'              => json_encode($values),
            ]);
        }
    }
}
    }
   

