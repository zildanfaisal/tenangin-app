<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suara', function (Blueprint $table) {
            if (!Schema::hasColumn('suara','status')) {
                $table->enum('status',[ 'recorded','uploading','transcribing','analyzed','failed' ])->default('recorded')->after('transkripsi');
            }
            if (!Schema::hasColumn('suara','duration_ms')) {
                $table->unsignedInteger('duration_ms')->nullable()->after('status');
            }
            if (!Schema::hasColumn('suara','language')) {
                $table->string('language',10)->nullable()->after('duration_ms');
            }
            if (!Schema::hasColumn('suara','asr_meta')) {
                $table->json('asr_meta')->nullable()->after('language');
            }
        });
    }

    public function down(): void
    {
        Schema::table('suara', function (Blueprint $table) {
            if (Schema::hasColumn('suara','asr_meta')) { $table->dropColumn('asr_meta'); }
            if (Schema::hasColumn('suara','language')) { $table->dropColumn('language'); }
            if (Schema::hasColumn('suara','duration_ms')) { $table->dropColumn('duration_ms'); }
            if (Schema::hasColumn('suara','status')) { $table->dropColumn('status'); }
        });
    }
};
