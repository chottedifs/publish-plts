<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class MasterStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_status'
    ];

    public function Pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'status_id', 'id');
    }

    public function Tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'status_id', 'id');
    }
}
