<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_lokasi'
    ];

    public function RelasiKios(): HasMany
    {
        return $this->hasMany(RelasiKios::class, 'lokasi_id', 'id');
    }

    public function HistoriKios(): HasMany
    {
        return $this->hasMany(HistoriKios::class, 'lokasi_id', 'id');
    }

    public function Petugas(): HasMany
    {
        return $this->hasMany(Petugas::class, 'lokasi_id', 'id');
    }

    public function SewaKios(): HasMany
    {
        return $this->hasMany(SewaKios::class, 'lokasi_id', 'id');
    }

    public function User(): HasMany
    {
        return $this->hasMany(User::class, 'lokasi_id', 'id');
    }

    public function Admin(): HasMany
    {
        return $this->hasMany(Admin::class, 'lokasi_id', 'id');
    }
}
