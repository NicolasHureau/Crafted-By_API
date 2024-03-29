<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login']);
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

//    /**
//     * Get the authenticated User
//     *
//     * @param Request $request
//     * @return JsonResponse [json] user object
//     */
//    public function user(Request $request)
//    {
//        return response()->json($request->user());
//    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $this->authorizeForUser(Auth::user(), 'update', [User::class, Auth::user()]);

        $request->validate([
            'email' => 'required|string|email',
            'old_password' => 'required|string',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $email = $request->get('email');
        $user = User::where('email', $email)->first();

        // Check the old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Update the user's password
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ], 200);
    }
}
