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

class BusinessController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return response()->json(Business::all());
        return BusinessResource::collection(Business::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessRequest $request)
    {
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
     */
    public function show(Business $business)
    {
        return new BusinessResource($business);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}
