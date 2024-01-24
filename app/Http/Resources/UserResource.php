<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';

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
            'lastname'  => $this->lastname,
            'firstname' => $this->firstname,
            $this->mergeWhen($request->user, [
                'email'     => $this->email,
                'address'   => $this->address,
                'zip_code'  => $this->zipCode->number,
                'city'      => $this->city->name,
                'business'  => BusinessResource::collection($this->business),
                'created_at' => $this->created_at,
            ]),
        ];
    }
}
