<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_batch',
        'kode_tagihan',
        'tagihan_id',
        'tgl_kirim',
        'tgl_terima',
        'lokasi_id',
        'master_status_id',
        'remarks',
        'periode',
    ];

    public function MasterStatus(): BelongsTo
    {
        return $this->belongsTo(MasterStatus::class);
    }

    public function Tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function Lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
