<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UsersController::class, 'store']);
Route::post('login', [UsersController::class, 'login']);
Route::post('logout', [UsersController::class, 'logout']);

Route::apiResource('users', UsersController::class);

Route::apiResource('business', BusinessController::class);

Route::apiResource('products', ProductsController::class);

Route::apiResource('invoices', InvoicesController::class);

