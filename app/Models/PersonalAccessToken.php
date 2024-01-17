<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

//

    public static function booted(): void
    {
        static::creating(function($model) {
            $model->id = Str::uuid();
        });
    }

}
