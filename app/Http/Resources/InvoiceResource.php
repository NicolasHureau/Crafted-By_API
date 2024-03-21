<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use mysql_xdevapi\Collection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="InvoiceModel",
 *     title="Invoice Model,
 *     type="Object,
 *     @OA\Property(
 *           property="Id",
 *           format="uuid",
 *           description="ID",
 *           title="ID",
 *      ),
 *     @OA\Property(property="customer", title="Invoice Customer", type="object",
 *          ref="#/components/schemas/UserCard"),
 *     @OA\Property(property="status", title="Invoice status", type="string"),
 *     @OA\Property(property="update_at", title="Invoice last update", type="date"),
 *     @OA\Property(property="products", title="Invoice products", type="array",
 *          @OA\Items(type="object", ref="#/components/schemas/ProductCard")),
 *     @OA\Property(property="total", title="Invoice total price", type="string")
 * )
 */
class InvoiceResource extends JsonResource
{
    public static $wrap = 'invoice';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

        return [
            'id'        => $this->id,
            'customer'  => new UserResource($this->customer),
            'status'    => $this->status->last()->name,
            'update_at' => $this->status->last()->pivot->updated_at,
            'products'  => ProductResource::collection($this->product),
            'total'     => ProductResource::collection($this->product)->sum(function (ProductResource $product) {
                return $product->pivot->quantity * $product->price;
            }),
        ];
    }
}
