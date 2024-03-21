<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

  /**
  * @OA\Schema(
  *     schema="ProductCard",
  *     title="ProductCard",
  *     description="Product Model for cards",
  *     type="object",
  *     @OA\Property(
  *         property="Id",
  *         format="uuid",
  *         description="ID",
  *         title="ID",
  *     ),
  *     @OA\Property(property="name", title="Name", description="Product name", type="string", example="Chaise en bois rare"),
  *     @OA\Property(property="image", title="Image", description="Image URL", type="string"),
  *     @OA\Property(property="price", title="Price", description="Product price", type="float", example="123.45"),
  *     @OA\Property(property="active", title="Active", description="Is product available to sell", type="boolean"),
  *     @OA\Property(property="business", title="Business from product", type="object",
   *            ref="#/components/schemas/BusinessCard")
  * ),
  * @OA\Schema(
  *     schema="ProductModel",
  *     title="Product Model",
  *     type="object",
  *     @OA\Property(
  *         property="Id",
  *         format="uuid",
  *         description="ID",
  *         title="ID",
  *     ),
  *     @OA\Property(property="name", title="Product name", description="Product name", type="string", example="Chaise en bois rare"),
  *     @OA\Property(property="image", title="Product image", description="Image URL", type="string"),
  *     @OA\Property(property="price", title="Product price", description="Product price", type="float", example="123.45"),
  *     @OA\Property(property="active", title="Is active", description="Is product available to sell", type="boolean"),
  *     @OA\Property(property="business", title="Business from product", type="object",
  *             ref="#/components/schemas/BusinessCard"),
  *     @OA\Property(property="description", title="Product description", description="Product description", type="string", example="Chaise en bois rare d'Indonésie taillé à la main."),
  *     @OA\Property(property="stock_quantity", title="Product stock quantity", description="Quantity of product available", type="int", example="7"),
  *     @OA\Property(property="height", title="Product height", type="string"),
  *     @OA\Property(property="width", title="Product width", type="string"),
  *     @OA\Property(property="depth", title="Product depth", type="string"),
  *     @OA\Property(property="capacity", title="product capacity", type="string"),
  *     @OA\Property(property="category", title="Product category", type="string"),
  *     @OA\Property(property="material", title="Product material", type="string"),
  *     @OA\Property(property="style", title="Product style", type="string"),
  *     @OA\Property(property="color", title="Product color", type="string"),
  *     @OA\Property(property="created_at", title="Product registery date", type="date")
  * )
  */
class ProductResource extends JsonResource
{
    public static $wrap = 'product';

    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

//        dd($this->whenPivotLoaded('invoice_product', function() {
//            return $this->pivot->quantity;
//        }));

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'image'     => $this->image,
            'price'     => $this->price,
            'active'    => $this->active,
            'business'      => new BusinessResource($this->business),
            $this->mergeWhen($request->product, [
                'description'   => $this->description,
                'stock_quantity'=> $this->stock_quantity,
                'height'        => $this->whenNotNull($this->size->height),
                'width'         => $this->whenNotNull($this->size->width),
                'depth'         => $this->whenNotNull($this->size->depth),
                'capacity'      => $this->whenNotNull($this->size->capacity),
                'category'      => $this->category->name,
                'material'      => $this->material->name,
                'style'         => $this->style->name,
                'color'         => $this->color->name,
//                'stock'         => $this->stock,
                'created_at'    => $this->created_at,
            ]),
            'quantity' => $this->whenPivotLoaded('invoice_product', function () {
                return $this->pivot->quantity;
            }),
            'total_product' => $this->whenPivotLoaded('invoice_product', function () {
                return $this->pivot->quantity * $this->price;
            })
        ];
    }
}
