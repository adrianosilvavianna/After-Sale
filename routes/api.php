<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteProductController;
use App\Http\Controllers\Api\ShopifyController;
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
    Route::get('shopify/get-products-by-ids', [ShopifyController::class, 'getProductsByIds']);
    Route::get('shopify/get-product-by-id', [ShopifyController::class, 'getProductById']);
    Route::get('shopify/get-product-by-name', [ShopifyController::class, 'getProductByName']);
    Route::get('favorite-product', [FavoriteProductController::class, 'index']);
    Route::post('favorite-product/create', [FavoriteProductController::class, 'create']);
    Route::post('/favorite-product/batch', [FavoriteProductController::class, 'addProductsToFavoritesBatch']);
});

