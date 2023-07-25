<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'tarif',
        'is_closed',
        'expedition_type_id',
        'frette',
        'douane',
        'colis_id',
        'totalKilo',
        'nombreTotalColis',
        'montantTotalColis',
        'nombreTotal',


    ];

    public function expeditionType()
    {
        return $this->belongsTo(ExpeditionType::class);
    }
}
