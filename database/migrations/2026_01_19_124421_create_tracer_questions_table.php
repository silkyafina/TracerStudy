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
        Schema::create('tracer_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_section_id')
                  ->constrained('tracer_sections')
                  ->cascadeOnDelete();
        
            $table->string('kode_pertanyaan')->nullable(); // f1201, f8, dll
            $table->text('pertanyaan');
            $table->enum('tipe_jawaban', [
                'text',
                'textarea',
                'radio',
                'checkbox',
                'select',
                'matrix_likert',
            ]);
        
            $table->integer('urutan');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_questions');
    }
};
