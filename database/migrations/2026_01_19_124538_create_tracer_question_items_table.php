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
        Schema::create('tracer_question_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_question_id')
                  ->constrained('tracer_questions')
                  ->cascadeOnDelete();
        
            $table->string('kode_item')->nullable(); // f1761, f1763, dst
            $table->string('label');
            $table->integer('urutan');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_question_items');
    }
};
