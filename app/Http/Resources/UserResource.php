<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

 /**
 * @OA\Schema(
 *     schema="UserCard",
 *     title="User card",
 *     description="Small User data",
 *     type="object",
 *     @OA\Property(
 *          property="Id",
 *          format="uuid",
 *          description="ID",
 *          title="ID",
 *     ),
 *     @OA\Property(property="lastname", title="User Lastname", type="string"),
 *     @OA\Property(property="firstname", title="User firstname", type="string"),
  *    @OA\Property(property="role", title="User role", type="string")
 * ),
 * @OA\Schema(
 *     schema="UserStore",
 *     description="User model to store",
 *     title="User Store",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(
 *          property="Id",
 *          format="uuid",
 *          description="ID",
 *          title="ID",
 *      ),
 *     @OA\Property(property="lastname", title="Lastname", type="string", example="Hureau"),
 *     @OA\Property(property="firstname", title="Firstname", type="string", example="Nicolas"),
 *     @OA\Property(property="email", title="Email", type="email", example="nicolas.hureau@crafted-by.com"),
 *     @OA\Property(property="password", title="password", type="password", example="password", required={"email", "password"}),
 *     @OA\Property(property="password_confirmation", type="password", example="password"),
 *     @OA\Property(property="address", title="Address", type="string", example="Papeteries"),
 *     @OA\Property(property="zip_code", title="Postal Code", type="string", example="74960"),
 *     @OA\Property(property="city", title="City", type="string", example="Cran-Gevrier")
 * ),
  * @OA\Schema(
  *     schema="UserModel",
  *     title="UserModel",
  *     description="User Model",
  *     type="object",
  *      @OA\Property(
  *           property="Id",
  *           format="uuid",
  *           description="ID",
  *           title="ID",
  *      ),
  *      @OA\Property(property="lastname", title="Lastname", type="string", example="Hureau"),
  *      @OA\Property(property="firstname", title="Firstname", type="string", example="Nicolas"),
  *      @OA\Property(property="email", title="Email", type="email", example="nicolas.hureau@crafted-by.com"),
  *      @OA\Property(property="address", title="Address", type="string", example="Papeteries"),
  *      @OA\Property(property="zip_code", title="Postal Code", type="string", example="74960"),
  *      @OA\Property(property="city", title="City", type="string", example="Cran-Gevrier"),
  *      @OA\Property(property="business", type="Business owned", type="object",
  *             ref="#/components/schemas/BusinessCard")
  * )
 */
class UserResource extends JsonResource
{
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

        return [
            'id'        => $this->id,
            'lastname'  => $this->lastname,
            'firstname' => $this->firstname,
            'role'      => $this->getRoleNames(),
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
