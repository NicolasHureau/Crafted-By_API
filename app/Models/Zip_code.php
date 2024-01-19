<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zip_code extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'zip_code';

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function business(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
