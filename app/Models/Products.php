<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory, HasUuids;

//    protected $keyType = 'string';
//    public $incrementing = false;
//
////
//
//    public static function booted(): void
//    {
//        static::creating(function($model) {
//            $model->id = Str::uuid();
//        });
//    }

}
