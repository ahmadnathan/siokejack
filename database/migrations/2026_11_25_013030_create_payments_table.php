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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->cascadeOnDelete();
    $table->enum('metode', ['tunai', 'transfer'])->default('tunai');
    $table->enum('status', ['belum', 'lunas'])->default('belum');
    $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamp('dibayar_pada')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
