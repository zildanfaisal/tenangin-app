<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass21_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('depresi_raw')->nullable();
            $table->unsignedTinyInteger('anxiety_raw')->nullable();
            $table->unsignedTinyInteger('stres_raw')->nullable();
            $table->unsignedTinyInteger('depresi_skor')->nullable();
            $table->unsignedTinyInteger('anxiety_skor')->nullable();
            $table->unsignedTinyInteger('stres_skor')->nullable();
            $table->unsignedSmallInteger('total_skor')->nullable();
            $table->string('depresi_kelas')->nullable();
            $table->string('anxiety_kelas')->nullable();
            $table->string('stres_kelas')->nullable();
            $table->string('hasil_kelas')->nullable();
            $table->string('overall_risk')->nullable();
            $table->text('overall_risk_note')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dass21_sessions');
    }
};
