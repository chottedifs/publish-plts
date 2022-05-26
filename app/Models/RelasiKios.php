<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelasiKios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kios_id',
        'lokasi_id',
        'tarif_kios_id',
        'status_relasi_kios',
    ];

    public function SewaKios(): HasOne
    {
        return $this->hasOne(SewaKios::class, 'relasi_kios_id', 'id');
    }

    public function Kios(): BelongsTo
    {
        return $this->belongsTo(Kios::class, 'kios_id');
    }

    public function Lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function TarifKios(): BelongsTo
    {
        return $this->belongsTo(TarifKios::class, 'tarif_kios_id');
    }
}
