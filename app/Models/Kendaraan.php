<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraans';
    protected $primaryKey = 'id_kendaraan'; 
    protected $fillable = ['nama_kendaraan'];

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class, 'id_kendaraan', 'id_kendaraan');
    }
}
