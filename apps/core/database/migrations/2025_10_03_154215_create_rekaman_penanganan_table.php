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
        Schema::create('rekaman_penanganan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analisis_id')->constrained('analisis')->onDelete('cascade');
            $table->enum('jenis_penanganan', ['konten', 'konsultan']);
            $table->foreignId('penanganan_id')->constrained('penanganan')->onDelete('cascade')->nullable();
            $table->foreignId('konsultan_id')->constrained('konsultan')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekaman_penanganan');
    }
};
