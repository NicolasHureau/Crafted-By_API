<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Theme",
 *     title="Business Theme",
 *     type="object",
 *     @OA\Property(property="layer", title="Theme Layer", type="string"),
 *     @OA\Property(property="color1", title="Theme color n°1", type="string"),
 *     @OA\Property(property="color2", title="Theme color n°2", type="string")
 * )
 */
class ThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'layer' => $this->layer,
            'color1' => $this->color_hex_1,
            'color2' => $this->color_hex_2,
        ];
    }
}
