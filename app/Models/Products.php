<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
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
