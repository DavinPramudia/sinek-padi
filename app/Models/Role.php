<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_roles';
    protected $fillable = ['nama_roles'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_roles', 'id_roles');
    }
}
