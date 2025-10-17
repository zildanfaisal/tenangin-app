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
        Schema::create('analisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dass21_session_id')->constrained('dass21_sessions')->onDelete('cascade');
            $table->foreignId('suara_id')->constrained('suara')->onDelete('cascade');
            $table->text('hasil_kondisi');
            $table->text('hasil_emosi');
            $table->text('ringkasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis');
    }
};
