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
        Schema::create('rekap_penilaians', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->string('periode');
            $table->string('rekap_pdf')->nullable();
            $table->string('rekap_perbulan_pdf')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_penilaians');
    }
};
