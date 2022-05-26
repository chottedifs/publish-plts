<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_lengkap',
        'lokasi_id',
        'rekening',
        'nik',
        'no_hp',
        'jenis_kelamin',
        'login_id'
    ];

    public function SewaKios(): HasOne
    {
        return $this->hasOne(SewaKios::class, 'user_id', 'id');
    }

    public function HistoriKios(): HasOne
    {
        return $this->hasOne(HistoriKios::class, 'user_id', 'id');
    }

    public function Lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
    }

    public function Login(): BelongsTo
    {
        return $this->belongsTo(Login::class, 'login_id', 'id');
    }
}
