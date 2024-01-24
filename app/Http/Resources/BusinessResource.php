<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            $specialities[] = $spec->name;
        }

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            $this->mergeWhen($request->business, [
                'owners'        => UserResource::collection($this->owner),
                'description'   => $this->description,
                'history'       => $this->history,
                'address'       => $this->email,
                'zip_code'      => $this->zipCode->number,
                'city'          => $this->city->name,
                'logo'          => $this->logo,
                'specialities'  => $specialities,
                'theme'         => new ThemeResource($this->theme),
                'products'      => ProductResource::collection($this->products),
                'created_at'    => $this->created_at,

            ]),
        ];
    }
}
