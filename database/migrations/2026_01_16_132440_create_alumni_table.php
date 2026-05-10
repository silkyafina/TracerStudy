<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
        
            // IDENTITAS
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->date('tanggal_lahir'); // dipakai login
            $table->string('nik')->nullable();
        
            // AKADEMIK
            $table->foreignId('prodi_id')->constrained('prodi');
            $table->year('tahun_lulus')->nullable();
        
            // KONTAK & DOMISILI
            $table->string('no_hp')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
