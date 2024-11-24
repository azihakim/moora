<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // php artisan migrate --path=database/migrations/2024_11_23_123848_create_penilaian_perbulans_table.php
    // php artisan migrate:rollback --path=database/migrations/2024_11_23_123848_create_penilaian_perbulans_table.php
    public function up(): void
    {
        Schema::create('penilaian_perbulans', function (Blueprint $table) {
            $table->id();
            $table->date('periode');
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreignId('id_kriteria');
            $table->foreign('id_kriteria')->references('id')->on('kriteria');
            // $table->foreignId('id_sub_kriteria');
            // $table->foreign('id_sub_kriteria')->references('id')->on('sub_kriteria');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_perbulans');
    }
};
