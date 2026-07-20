<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    protected $table = 'tarifs';
    protected $primaryKey = 'id_tarif';
    protected $fillable = ['harga_tarif', 'id_kendaraan'];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_tarif', 'id_tarif');        
    }
}