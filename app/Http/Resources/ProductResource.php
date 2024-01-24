<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'product';

    /**
     * Transform the resource into an array.
     *
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
            $this->mergeWhen($request->product, [
                'business'      => new BusinessResource($this->business),
                'description'   => $this->description,
                'height'        => $this->whenNotNull($this->size->height),
                'width'         => $this->whenNotNull($this->size->width),
                'depth'         => $this->whenNotNull($this->size->depth),
                'capacity'      => $this->whenNotNull($this->size->capacity),
                'category'      => $this->category->name,
                'material'      => $this->material->name,
                'style'         => $this->style->name,
                'color'         => $this->color->name,
                'stock'         => $this->stock,
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
