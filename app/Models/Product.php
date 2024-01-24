<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasUuids;

//    protected $keyType = 'string';
//    public $incrementing = false;
//
//    public static function booted(): void
//    {
//        static::creating(function($model) {
//            $model->id = Str::uuid();
//        });
//    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image',
        'active',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function invoice(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class)
            ->withPivot('quantity');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
