<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Models\User;
use App\Models\Zip_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return response()->json(User::all());
        return UserResource::collection(User::all());
    }

//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create()
//    {
//        dd('yo');
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $requestData = $request->all();

        $zipCode = Zip_code::firstOrCreate(['number' => $requestData['zip_code']]);
        $requestData['zip_code_id'] = $zipCode->id;

        $city = City::firstOrCreate(['name', $requestData['city']]);
        $requestData['city_id'] = $city->id;

        $user = User::create($requestData);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(UsersController $user)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
