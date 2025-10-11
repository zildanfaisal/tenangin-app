<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dass21_items', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // D1..D7 A1..A7 S1..S7
            $table->text('pernyataan');
            $table->enum('subskala', ['depresi','anxiety','stres']);
            $table->unsignedTinyInteger('urutan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dass21_items');
    }
};
