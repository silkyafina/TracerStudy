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
    Schema::table('users', function (Blueprint $table) {

        $table->unsignedBigInteger('alumni_id')->nullable()->after('id');

        $table->string('username')->unique()->after('name');

        $table->enum('role', [
            'alumni',
            'admin',
            'admin_prodi',
            'staf'
        ])->default('alumni')->after('password');

        $table->foreign('alumni_id')
              ->references('id')
              ->on('alumni')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
