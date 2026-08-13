<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailWisatawanTransaksi extends Model
{
    protected $table = 'detail_wisatawan_transaksis'; 
    protected $primaryKey = 'id_detail_wisatawan_transaksi'; 
    protected $fillable = ['id_transaksi', 'id_kategori_wisatawan', 'jumlah_jiwa']; 

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function kategoriWisatawan(): BelongsTo
    {
        return $this->belongsTo(KategoriWisatawan::class, 'id_kategori_wisatawan', 'id_kategori_wisatawan');
    }
}