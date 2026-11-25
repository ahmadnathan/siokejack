<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'pelanggan_id', 'driver_id', 'zona_asal_id', 'zona_tujuan_id',
    'alamat_jemput', 'alamat_tujuan', 'catatan', 'tarif', 'status',
])]
class Order extends Model
{
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function zonaAsal(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zona_asal_id');
    }

    public function zonaTujuan(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zona_tujuan_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}