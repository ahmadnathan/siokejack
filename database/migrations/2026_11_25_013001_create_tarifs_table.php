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
        Schema::create('tarifs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('zona_asal_id')->constrained('zones')->cascadeOnDelete();
    $table->foreignId('zona_tujuan_id')->constrained('zones')->cascadeOnDelete();
    $table->unsignedInteger('harga');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};
