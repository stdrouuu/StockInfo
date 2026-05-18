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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->string('tujuan', 255)->nullable();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['diproses', 'selesai', 'dibatalkan'])->default('diproses');
            $table->decimal('total_nilai', 15, 2)->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
