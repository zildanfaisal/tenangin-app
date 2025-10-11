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
        Schema::table('konsultan', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('foto');
            $table->enum('kategori', ['konselor', 'konsultan'])->after('spesialisasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultan', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'kategori']);
        });
    }
};
