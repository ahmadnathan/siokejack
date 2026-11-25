<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['zona_asal_id', 'zona_tujuan_id', 'harga'])]
class Tarif extends Model
{
    public function zonaAsal(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zona_asal_id');
    }

    public function zonaTujuan(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zona_tujuan_id');
    }
}       