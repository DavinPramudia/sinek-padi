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
        Schema::create('detail_wisatawan_transaksis', function (Blueprint $table) {
            $table->id('id_detail_wisatawan_transaksi');
            
            $table->foreignId('id_transaksi')->constrained('transaksis', 'id_transaksi')->onDelete('cascade');
            $table->foreignId('id_kategori_wisatawan')->constrained('kategori_wisatawans', 'id_kategori_wisatawan')->onDelete('cascade');
        
            $table->integer('jumlah_jiwa'); // Jumlah orang per kategori
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
