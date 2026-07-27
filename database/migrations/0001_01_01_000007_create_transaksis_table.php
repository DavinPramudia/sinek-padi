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
            $table->id('id_transaksi');
            $table->string('no_karcis')->unique();
            $table->bigInteger('total_bayar');
            $table->dateTime('waktu');
            
            // Kolom tambahan sesuai fitur yang kita bahas
            $table->integer('reprint_count')->default(0); // Untuk mencatat jumlah print ulang
            $table->string('metode_cetak')->default('print'); // e-ticket atau print fisik

            // Foreign Key
            $table->foreignId('id_users')->constrained('users', 'id_users')->onDelete('cascade');
            $table->foreignId('id_tarif')->constrained('tarifs', 'id_tarif')->onDelete('cascade');

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