<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksis'; 
    protected $primaryKey = 'id_transaksi'; 
    protected $fillable = ['no_karcis', 'total_bayar', 'waktu', 'id_users', 'id_tarif','reprint_count','metode_cetak']; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function tarif(): BelongsTo
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailWisatawanTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}