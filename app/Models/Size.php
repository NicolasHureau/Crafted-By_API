<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'height',
        'widht',
        'depth',
        'capacity'
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Products::class);
    }

}
