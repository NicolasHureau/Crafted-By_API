<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Models\User;
use App\Models\Zip_code;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Assign to ALL methods in this Controller
//        $this->middleware('auth');

        // Assign only to ONE or spécific method in this Controller
//        $this->middleware('guest')->only(['index', 'show']);

        // Assign to all EXCEPT specific methods in this Controller
//        $this->middleware('guest')->except(['store', 'update', 'destroy']);

//        $this->middleware('guest')->only(['store', 'login']);
        $this->middleware('auth:sanctum')->except(['store', 'login']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
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

        $city = City::firstOrCreate(['name' => $requestData['city']]);
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

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
//            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' =>$token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    }
}
