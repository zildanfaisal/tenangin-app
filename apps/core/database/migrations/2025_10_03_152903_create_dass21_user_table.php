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
        Schema::create('dass21_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('anxiety_skor')->nullable();
            $table->string('depresi_skor')->nullable();
            $table->string('stres_skor')->nullable();
            $table->string('total_skor')->nullable();
            $table->string('anxiety_kelas')->nullable();
            $table->string('depresi_kelas')->nullable();
            $table->string('stres_kelas')->nullable();
            $table->string('hasil_kelas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dass21_user');
    }
};
