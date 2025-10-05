<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass21_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dass21_session_id')->constrained('dass21_sessions')->onDelete('cascade');
            $table->foreignId('dass21_item_id')->constrained('dass21_items')->onDelete('cascade');
            $table->unsignedTinyInteger('nilai'); // 0-3
            $table->timestamps();
            $table->unique(['dass21_session_id','dass21_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dass21_responses');
    }
};
