<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriWisatawan extends Model
{
    protected $table = 'kategori_wisatawans';
    protected $primaryKey = 'id_kategori_wisatawan';
    protected $fillable = ['nama_kategori_wisatawan'];

    public function details(): HasMany
    {
        return $this->hasMany(DetailWisatawanTransaksi::class, 'id_kategori', 'id_kategori');
    }
}
