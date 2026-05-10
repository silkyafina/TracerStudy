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
        Schema::create('tracer_answers', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('tracer_session_id')
                  ->constrained('tracer_sessions')
                  ->cascadeOnDelete();
        
            $table->foreignId('tracer_question_id')
                  ->constrained('tracer_questions')
                  ->cascadeOnDelete();
        
            $table->foreignId('tracer_item_id')
                  ->nullable()
                  ->constrained('tracer_question_items')
                  ->cascadeOnDelete();
        
            $table->string('value'); // isi jawaban
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_answers');
    }
};
