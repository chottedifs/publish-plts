<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriKios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sewa_kios_id',
        'tgl_awal_sewa',
        'tgl_akhir_sewa',
        'lokasi_id',
    ];

    public function Tagihan(): HasOne
    {
        return $this->hasOne(Tagihan::class);
    }

    public function SewaKios(): BelongsTo
    {
        return $this->belongsTo(SewaKios::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
