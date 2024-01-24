<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use mysql_xdevapi\Collection;

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
