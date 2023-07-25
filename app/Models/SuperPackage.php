<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "max_weight",
        "cargo_id",
        "user_id"
    ];

    public function cargo()
    {
        return $this->belongsTo(Expedition::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
