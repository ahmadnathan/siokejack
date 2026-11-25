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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pelanggan_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
    $table->foreignId('zona_asal_id')->constrained('zones');
    $table->foreignId('zona_tujuan_id')->constrained('zones');
    $table->string('alamat_jemput');
    $table->string('alamat_tujuan');
    $table->text('catatan')->nullable();
    $table->unsignedInteger('tarif');
    $table->enum('status', ['menunggu', 'diterima', 'dijemput', 'selesai', 'dibatalkan'])
          ->default('menunggu');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
