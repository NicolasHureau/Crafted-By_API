<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="BusinessCard",
 *     description="Small Business Data",
 *     title="Business Card",
 *     type="object",
 *     @OA\Property(
 *         property="Id",
 *         format="uuid",
 *         description="ID",
 *         title="ID",
 *     ),
 *     @OA\Property(property="name", title="Business name", type="string"),
 *     @OA\Property(property="email", title="Business email", type="string"),
 *     @OA\Property(property="theme", title="Business theme", type="object",
 *          ref="#/components/schemas/Theme")
 * ),
 * @OA\Schema(
 *     schema="BusinessStore",
 *     description="Business model to Store",
 *     title="Business Store",
 *     type="object",
 *     @OA\Property(
 *           property="Id",
 *           format="uuid",
 *           description="ID",
 *           title="ID",
 *     ),
 *     @OA\Property(property="name", title="Business name", type="string"),
 *     @OA\Property(property="email", title="Business email", example="business@business.com", type="string"),
 *     @OA\Property(property="theme", title="Business theme", type="object",
 *          ref="#/components/schemas/Theme"),
 *      @OA\Property(property="description", title="Business description", type="string"),
 *      @OA\Property(property="history", title="Business history", type="string"),
 *      @OA\Property(property="address", title="Business address", example="Papeteries", type="string"),
 *      @OA\Property(property="zip_code", title="Business post code", example="74960", type="string"),
 *      @OA\Property(property="city", title="Business city location", example="Cran-Gevrier", type="string"),
 *      @OA\Property(property="logo", title="Business logo", type="string"),
 *      @OA\Property(property="specialities", title="Business specialities", type="array",
 *           @OA\Items(type="string")),
 *
 * ),
 * @OA\Schema(
 *     schema="BusinessModel",
 *     title="Business Model",
 *     type="object",
 *     @OA\Property(
 *          property="Id",
 *          format="uuid",
 *          description="ID",
 *          title="ID",
 *      ),
 *     @OA\Property(property="name", title="Business name", type="string"),
 *     @OA\Property(property="email", title="Business email", type="string"),
 *     @OA\Property(property="theme", title="Business theme", type="object",
 *          ref="#/components/schemas/Theme"),
 *     @OA\Property(property="owners", title="Business Owners", type="array",
 *          @OA\Items(type="object", ref="#/components/schemas/UserCard")),
 *     @OA\Property(property="description", title="Business description", type="string"),
 *     @OA\Property(property="history", title="Business history", type="string"),
 *     @OA\Property(property="address", title="Business address", type="string"),
 *     @OA\Property(property="zip_code", title="Business post code", type="string"),
 *     @OA\Property(property="city", title="Business city location", type="string"),
 *     @OA\Property(property="logo", title="Business logo", type="string"),
 *     @OA\Property(property="specialities", title="Business specialities", type="array",
 *          @OA\Items(type="string")),
 *     @OA\Property(property="products", title="Business products", type="array",
 *          @OA\Items(type="object", ref="#/components/schemas/ProductCard")),
 *     @OA\Property(property="created_at", title="Business registering date", type="date")
 * )
 */
class BusinessResource extends JsonResource
{
    public static $wrap = 'business';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

        $specialities = [];
        foreach ($this->speciality as $spec){
            $specialities[] = [
                'id' => $spec->id,
                'name' => $spec->name
            ];
        }

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'logo'          => $this->logo,
            'theme'         => new ThemeResource($this->theme),
            $this->mergeWhen($request->business, [
                'owners'        => UserResource::collection($this->owner),
                'description'   => $this->description,
                'history'       => $this->history,
                'address'       => $this->address,
                'zip_code'      => $this->zipCode->number,
                'city'          => $this->city->name,
                'specialities'  => $specialities,
                'products'      => ProductResource::collection($this->products),
                'created_at'    => $this->created_at,
            ]),
        ];
    }
}
