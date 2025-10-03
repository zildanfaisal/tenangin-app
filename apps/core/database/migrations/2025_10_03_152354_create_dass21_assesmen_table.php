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
        Schema::create('dass21_assesmen', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->string('jawaban');
            $table->enum('kategori', ['depresi', 'anxiety', 'stres']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dass21_assesmen');
    }
};
