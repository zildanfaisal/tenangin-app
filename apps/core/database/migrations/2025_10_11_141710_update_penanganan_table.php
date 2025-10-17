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
        Schema::table('penanganan', function (Blueprint $table) {
            $table->dropColumn(['tahapan_penanganan', 'tutorial_penanganan', 'video_penanganan', 'durasi_detik', 'tingkat_kesulitan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penanganan', function (Blueprint $table) {
            //
        });
    }
};
