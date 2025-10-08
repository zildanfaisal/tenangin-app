<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('penanganan', function (Blueprint $table) {
            $table->string('slug')->unique()->after('id');
            $table->enum('status',[ 'draft','published' ])->default('draft')->after('video_penanganan');
            $table->unsignedSmallInteger('durasi_detik')->nullable()->after('status');
            $table->string('cover_path')->nullable()->after('durasi_detik');
            $table->enum('tingkat_kesulitan',[ 'mudah','sedang','sulit' ])->default('mudah')->after('cover_path');
            $table->unsignedInteger('ordering')->default(0)->after('tingkat_kesulitan');
        });
    }

    public function down(): void {
        Schema::table('penanganan', function (Blueprint $table) {
            $table->dropColumn([
                'slug','status','durasi_detik','cover_path','tingkat_kesulitan','ordering'
            ]);
        });
    }
};