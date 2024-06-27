<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShopifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::get('shopify/getProductsByIds', [ShopifyController::class, 'getProductsByIds']);
    Route::get('shopify/getProductById', [ShopifyController::class, 'getProductById']);
    Route::post('shopify/createProduct', [ShopifyController::class, 'createProduct']);
});
