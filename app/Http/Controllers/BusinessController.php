<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\City;
use App\Models\Speciality;
use App\Models\Theme;
use App\Models\Zip_code;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;
use Ramsey\Collection\Collection;
use Symfony\Component\HttpFoundation\Response;

class BusinessController extends Controller
{
    /**
     * Instantiate a new controller instance with sanctum middleware exceptions.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/business",
     *     summary="Get a list of business",
     *     tags={"Business"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful opération",
     *         @OA\JsonContent(type="array",
     *              @OA\Items(type="object", ref="#/components/schemas/BusinessCard"))
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index(): ResourceCollection
    {
        $businesses = Business::query();

        if (request()->has('search'))
        {
            $businesses = $businesses->search(request()->query('search'));
        }

        $businesses = $businesses->get();

        return BusinessResource::collection($businesses);
    }

    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *     path="/business",
     *     summary="Business Store",
     *     tags={"Business"},
     *     operationId="addBusiness",
     *     description="Create Business",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BusinessStore")
     *     ),
     *     @OA\Response(
     *         response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusinessCard")
     *     ),
     *     @OA\Response(
     *         response=405,
     *          description="Invalid Input"
     *     )
     * )
     */
    public function store(StoreBusinessRequest $request)
    {
        $this->authorize('create', $request);
        $requestData = $request->all();

        $zipCode = Zip_code::firstOrCreate(['number', $requestData['zip_code']]);
        $requestData['zip_code_id'] = $zipCode->id;

        $city = City::firstOrCreate(['name', $requestData['city']]);
        $requestData['city_id'] = $city->id;

        $theme = Theme::firstOrCreate([
            'layer' => $requestData['layer'],
            'color_hex_1' => $requestData['color_hex_1'],
            'color_hex_2' => $requestData['color_hex_2'],
        ]);
        $requestData['theme_id'] = $theme->id;

        $biz = Business::create($requestData);

//        $biz->attach(user);

        foreach ($requestData['speciality'] as $spec) {
            $speciality = Speciality::where('name', $spec)->first();
            if (null === $speciality) {
                $speciality = Speciality::create(['name' => $spec]);
            }
            $biz->attach($speciality);
        }

        return new BusinessResource($biz);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *     path="/business/{business_id}",
     *     summary="Find a business by Id",
     *     description="Return a single business",
     *     tags={"Business"},
     *     operationId="getBusinessById",
     *     @OA\Parameter(
     *         name="business_id",
     *          in="path",
     *          description="Id of business to return",
     *          required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusinessModel")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function show(Business $business): BusinessResource
    {
        return new BusinessResource($business);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *       path="/business/{business_id}",
     *       operationId="updateBusiness",
     *       tags={"Business"},
     *       summary="Update existing business",
     *       description="Returns updated business data",
     *       security={ {"sanctum": {} }},
     *       @OA\Parameter(
     *           name="business_id",
     *           description="Business id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(type="uuid")
     *       ),
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/BusinessModel")
     *       ),
     *       @OA\Response(
     *           response="202",
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/BusinessModel")
     *       ),
     *       @OA\Response(response=400, description="Bad Request"),
     *       @OA\Response(response=401, description="Unauthenticated"),
     *       @OA\Response(response=403, description="Forbidden"),
     *       @OA\Response(response=404, description="Resource Not Found")
     *   )
     */
    public function update(UpdateBusinessRequest $request, Business $business): JsonResponse
    {
        $this->authorize('update', $business);

        $business->update($request->all());

        return (new BusinessResource($business))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *         path="/business/{business_id}",
     *         operationId="deleteBusiness",
     *         tags={"Business"},
     *         summary="Delete existing business",
     *         description="Deletes a record and returns no content",
     *         security={ {"sanctum": {} }},
     *         @OA\Parameter(
     *             name="business_id",
     *             description="Business id",
     *             required=true,
     *             in="path",
     *             @OA\Schema(
     *                 type="uuid"
     *             )
     *         ),
     *         @OA\Response(
     *             response=204,
     *             description="Successful operation",
     *             @OA\JsonContent()
     *          ),
     *        @OA\Response(response=401, description="Unauthenticated"),
     *        @OA\Response(response=403, description="Forbidden"),
     *        @OA\Response(response=404, description="Resource Not Found")
     *    )
 */
    public function destroy(Business $business): Response
    {
        $this->authorize('delete', $business);

        $business->delete();

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
