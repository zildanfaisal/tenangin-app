<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penanganan_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penanganan_id')->constrained('penanganan')->onDelete('cascade');
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('urutan')->default(1);
            $table->unsignedInteger('durasi_detik')->default(60);
            $table->string('video_path')->nullable();
            $table->text('instruksi')->nullable();
            $table->enum('status',[ 'draft','published' ])->default('published');
            $table->timestamps();
            $table->unique(['penanganan_id','urutan']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('penanganan_steps');
    }
};