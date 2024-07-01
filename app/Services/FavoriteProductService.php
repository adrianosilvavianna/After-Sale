<?php

namespace App\Services;

use App\Models\FavoriteProduct;
use Exception;

class FavoriteProductService 
{
    protected $favoriteProduct;

    public function __construct(FavoriteProduct $favoriteProduct)
    {
        $this->favoriteProduct = $favoriteProduct;
    }

    public function createFavoriteProductByShopifyProdut($product)
    {
        $this->favoriteProduct->shopify_product_id = $product->id;
        $this->favoriteProduct->title = $product->title;
        $this->favoriteProduct->body_html = $product->body_html;
        $this->favoriteProduct->vendor = $product->vendor;
        $this->favoriteProduct->handle =  $product->handle;
        $this->favoriteProduct->status = $product->status;

        auth()->user()->favoriteProducts()->save($this->favoriteProduct);

        return $this->favoriteProduct;
    }

    public function validateUserHasFavoriteProduct($product)
    {    
        $user = auth()->user();
        //Validar se o usuário já add aos favoridos
        $favoriteProduct = $user->favoriteProducts()->where('shopify_product_id', $product->id)->count();

        if($favoriteProduct > 0){
            return false;
        }else{
            return true;
        }
    }

    public function checkExistingFavoriteProducts(array $productIds)
    {
        $user = auth()->user();
        $existingProducts = $user->favoriteProducts()->whereIn('shopify_product_id', $productIds)->pluck('shopify_product_id')->toArray();
        
        if(empty($existingProducts)){
            return false;
        }else{
            return $existingProducts;
        }
        
    }
}