<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * Class Product
 *
 * @OA\Schema(
 *     description="Product model",
 *     title="Product model",
 *     type="object",
 *     required={"name", "price"},
 *     @OA\Property(
 *         property="Id",
 *         format="uuid",
 *         description="ID",
 *         title="ID",
 *     ),
 *     @OA\Property(property="name", title="Name", description="Product name", type="string", example="Chaise en bois rare"),
 *     @OA\Property(property="description", title="Description", description="Product description", type="string", example="Chaise en bois rare d'Indonésie taillé à la main."),
 *     @OA\Property(property="price", title="Price", description="Product price", type="float", example="123.45"),
 *     @OA\Property(property="stock_quantity", title="Stock quantity", description="Quantity of product available", type="int", example="7"),
 *     @OA\Property(property="image", title="Image", description="Image URL", type="url"),
 *     @OA\Property(property="active", title="Active", description="Is product available to sell", type="boolean")
 * )
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
        'stock_quantity',
        'image',
        'active',
    ];

    /**
     * @OA\Property(
     *     title="Business",
     *     description="Artisan who sell product",
     *     type="object"
     * )
     * @var Business
     * @return BelongsTo
     */
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
