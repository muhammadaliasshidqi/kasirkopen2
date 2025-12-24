<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi'); // GANTI NAMA KOLOM
            $table->unsignedBigInteger('id_menu'); // GANTI NAMA KOLOM
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            // Foreign keys - SESUAIKAN DENGAN NAMA KOLOM YANG BENAR
            $table->foreign('id_transaksi')
                  ->references('id_transaksi') // GANTI INI
                  ->on('transaksi')
                  ->onDelete('cascade');
                  
            $table->foreign('id_menu')
                  ->references('id_menu') // GANTI INI
                  ->on('menu')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};