<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifKios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipe',
        'harga'
    ];

    public function RelasiKios(): HasMany
    {
        return $this->hasMany(RelasiKios::class, 'tarif_kios_id', 'id');
    }
}
