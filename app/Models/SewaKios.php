<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SewaKios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'relasi_kios_id',
        'status_sewa',
        'lokasi_id'
    ];

    public function Tagihan(): HasOne
    {
        return $this->hasOne(Tagihan::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function RelasiKios(): BelongsTo
    {
        return $this->belongsTo(RelasiKios::class);
    }

    public function Lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function HistoriKios(): HasMany
    {
        return $this->hasMany(HistoriKios::class);
    }
}
