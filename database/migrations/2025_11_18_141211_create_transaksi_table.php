<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->date('tanggal');
            $table->decimal('total', 12, 2);
            $table->unsignedBigInteger('id_kasir');
            $table->string('metode_pembayaran', 50)->default('tunai');
            $table->decimal('bayar', 12, 2)->nullable();
            $table->decimal('kembalian', 12, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_kasir')
                  ->references('id_kasir')
                  ->on('kasir')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};