<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_survey_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_survey_id')
                  ->constrained()
                  ->onDelete('cascade');

            // =========================
            // PENILAIAN KOMPETENSI (1-5)
            // =========================
            $table->tinyInteger('integritas');
            $table->tinyInteger('keahlian');
            $table->tinyInteger('bahasa_inggris');
            $table->tinyInteger('teknologi_informasi');
            $table->tinyInteger('komunikasi');
            $table->tinyInteger('kerjasama_tim');
            $table->tinyInteger('pengembangan_diri');

            // =========================
            // IDENTITAS PENILAI
            // =========================
            $table->string('nama_atasan');
            $table->string('nip')->nullable();
            $table->string('jabatan_atasan');
            $table->string('nama_perusahaan');
            $table->text('alamat_perusahaan');

            $table->text('saran')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_survey_answers');
    }
};
  