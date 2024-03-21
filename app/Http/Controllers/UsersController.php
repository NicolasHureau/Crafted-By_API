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
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

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
     * @OA\Get(
     *      path="/users",
     *      summary="Get a list of users",
     *      tags={"Users"},
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array",
     *              @OA\Items(type="object", ref="#/components/schemas/UserCard")
     *          )
     *      ),
     *      @OA\Response(response=400, description="Invalid request")
     *  )
     */
    public function index(): ResourceCollection
    {
        $this->authorize('viewany', Auth::user());

        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *     path="/users",
     *     summary="User Store",
     *     tags={"Users"},
     *     operationId="addUser",
     *     description="Create User",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserStore"),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UserCard")
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $requestData = $request->all();

        $zipCode = Zip_code::firstOrCreate(['number' => $requestData['zip_code']]);
        $requestData['zip_code_id'] = $zipCode->id;

        $city = City::firstOrCreate(['name' => $requestData['city']]);
        $requestData['city_id'] = $city->id;

        $user = User::create($requestData);
        $user->assignRole('customer');

        $user = new UserResource($user);
        return $this->getToken($user);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *         path="/users/{user_id}",
     *         summary="Find a user by Id",
     *         description="Return a single user",
     *         tags={"Users"},
     *         operationId="getUserById",
     *         security={ {"sanctum": {} }},
     *         @OA\Parameter(
     *           name="user_id",
     *           in="path",
     *           description="Id of user to return",
     *           required=true
     *         ),
     *         @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/UserModel")
     *         ),
     *         @OA\Response(response=400, description="Invalid request")
     *     )
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *      path="/users/{user_id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserUpdate")
     *      ),
     *      @OA\Response(
     *          response="202",
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserModel")
     *      ),
     *       @OA\Response(response=400, description="Bad Request"),
     *       @OA\Response(response=401, description="Unauthenticated"),
     *       @OA\Response(response=403, description="Forbidden"),
     *       @OA\Response(response=404, description="Resource Not Found")
     *  )
 */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->all());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *        path="/users/{user_id}",
     *        operationId="deleteUser",
     *        tags={"Users"},
     *        summary="Delete existing user",
     *        description="Deletes a record and returns no content",
     *        security={ {"sanctum": {} }},
     *        @OA\Parameter(
     *            name="user_id",
     *            description="User id",
     *            required=true,
     *            in="path",
     *            @OA\Schema(type="uuid")
     *        ),
     *        @OA\Response(
     *            response=204,
     *            description="Successful operation",
     *            @OA\JsonContent()
     *         ),
     *        @OA\Response(response=401, description="Unauthenticated"),
     *        @OA\Response(response=403, description="Forbidden"),
     *        @OA\Response(response=404, description="Resource Not Found")
     *   )
 */
    public function destroy(User $user)
    {
        $this->authorize('delete', Auth::user());

        $user->delete();

        return \response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Login user and create token
     * @OA\Post(
     *     path="/login",
     *     operationId="loginUser",
     *     tags={"Users"},
     *     summary="Login User",
     *     description="Login User",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", example="nicolas.hureau@crafted-by.com"),
     *              @OA\Property(property="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 type="string",
     *                 description="Bearer token",
     *                 property="accessToken"
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 description="Token type",
     *                 property="token_type"
     *             ),
     *             @OA\Property(
     *                 type="object",
     *                 description="User object",
     *                 property="user",
     *                  ref="#/components/schemas/UserCard"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=405,
     *          description="Invalid input"
     *     ),
     * )
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

        if (!Auth::attempt($credentials)) {

            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $email = $request->get('email');
        $user = User::where('email', $email)->first();
        $user = new UserResource($user);

        return $this->getToken($user);
    }

    private function getToken(UserResource $user): JsonResponse
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
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
