<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penanganan', function (Blueprint $table) {
            if (!Schema::hasColumn('penanganan','kelompok')) {
                $table->enum('kelompok', ['depresi','stres','anxiety'])->default('anxiety')->after('deskripsi_penanganan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penanganan', function (Blueprint $table) {
            if (Schema::hasColumn('penanganan','kelompok')) {
                $table->dropColumn('kelompok');
            }
        });
    }
};
