<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'tarif',
        'is_closed',
        'cargo_type_id',
        'user_id'
    ];

    public function cargoType()
    {
        return $this->belongsTo(CargoType::class);
    }
}
