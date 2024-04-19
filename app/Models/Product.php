<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Annotations as OA;
use Illuminate\Database\Eloquent\Builder;

 /**
 * Class Product
 */
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
        'stock',
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

    // Laravel Scopes for query building

    public function scopeColor(Builder $query, string $color)
    {
        return $query->where('color_id', $color);
    }
    public function scopeStyle(Builder $query, string $style)
    {
        return $query->where('style_id', $style);
    }
    public function scopeMaterial(Builder $query, string $material)
    {
        return $query->where('material_id', $material);
    }
    public function scopeCategory(Builder $query, string $category)
    {
        return $query->where('category_id', $category);
    }
    public function scopeSearch(Builder $query, string $input)
    {
        return $query->where('name','LIKE', '%'.$input.'%')
            ->orWhereHas('color', function ($query) use ($input) {
                return $query->where('name', 'LIKE', '%' . $input . '%');
            })
            ->orWhereHas('style', function ($query) use ($input) {
                return $query->where('name', 'LIKE', '%' . $input . '%');
            })
            ->orWhereHas('material', function ($query) use ($input) {
                return $query->where('name', 'LIKE', '%' . $input . '%');
            })
            ->orWhereHas('category', function ($query) use ($input) {
                return $query->where('name', 'LIKE', '%' . $input . '%');
            });
    }
}
