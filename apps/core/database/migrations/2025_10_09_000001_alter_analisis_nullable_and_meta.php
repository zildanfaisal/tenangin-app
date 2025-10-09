<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analisis', function (Blueprint $table) {
            if (!Schema::hasColumn('analisis', 'status')) {
                $table->enum('status', ['pending','completed','failed'])->default('pending')->after('ringkasan');
            }
            if (!Schema::hasColumn('analisis', 'model_name')) {
                $table->string('model_name')->nullable()->after('status');
            }
            if (!Schema::hasColumn('analisis', 'model_version')) {
                $table->string('model_version')->nullable()->after('model_name');
            }
            if (!Schema::hasColumn('analisis', 'scores')) {
                $table->json('scores')->nullable()->after('model_version');
            }
            if (!Schema::hasColumn('analisis', 'notes')) {
                $table->text('notes')->nullable()->after('scores');
            }
        });
        // Make dass21_session_id nullable if column exists
        if (Schema::hasColumn('analisis', 'dass21_session_id')) {
            Schema::table('analisis', function (Blueprint $table) {
                $table->foreignId('dass21_session_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('analisis', function (Blueprint $table) {
            if (Schema::hasColumn('analisis', 'notes')) { $table->dropColumn('notes'); }
            if (Schema::hasColumn('analisis', 'scores')) { $table->dropColumn('scores'); }
            if (Schema::hasColumn('analisis', 'model_version')) { $table->dropColumn('model_version'); }
            if (Schema::hasColumn('analisis', 'model_name')) { $table->dropColumn('model_name'); }
            if (Schema::hasColumn('analisis', 'status')) { $table->dropColumn('status'); }
        });
        if (Schema::hasColumn('analisis', 'dass21_session_id')) {
            Schema::table('analisis', function (Blueprint $table) {
                $table->foreignId('dass21_session_id')->nullable(false)->change();
            });
        }
    }
};
