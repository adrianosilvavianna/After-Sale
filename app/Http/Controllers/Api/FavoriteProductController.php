<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NullVariableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFavoriteProductsRequest;
use App\Jobs\AddToFavoritesJob;
use App\Models\FavoriteProduct;
use App\Rules\UniqueProductFavorite;
use App\Services\FavoriteProductService;
use App\Services\ShopifyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteProductController extends Controller
{
    protected $shopify;
    protected $user;

    public function __construct(ShopifyService $shopify)
    {
        $this->shopify = $shopify;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return response()->json($user->favoriteProducts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RegisterFavoriteProductsRequest $request, FavoriteProductService $favoriteProductService)
    {
        try {
            $shopify = $this->shopify->getProductById($request->shopify_product_id);
            $user = auth()->user();

            $validateUserHasFavoriteProduct = $favoriteProductService->validateUserHasFavoriteProduct($shopify->product);

            if($validateUserHasFavoriteProduct != true){
                throw new Exception("O produto: ". $shopify->product ." já foi favoritado!");
            }

            return $favoriteProductService->createFavoriteProductByShopifyProdut($shopify->product); 

        } catch (Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro: ' . $e->getMessage()], 500);
        }
    }

    public function addProductsToFavoritesBatch(Request $request)
    {
        try {
            // Despachar o job para a fila
            AddToFavoritesJob::dispatch($request->product_shopify_ids);

            return response()->json(['message' => 'Os produtos foram enviados para a fila de favoritos!'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FavoriteProduct  $favoriteProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavoriteProduct $favoriteProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FavoriteProduct  $favoriteProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteProduct $favoriteProduct)
    {
        //
    }
}
