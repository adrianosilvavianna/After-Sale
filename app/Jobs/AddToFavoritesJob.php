<?php

namespace App\Jobs;

use App\Models\FavoriteProduct;
use App\Services\FavoriteProductService;
use App\Services\ShopifyService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddToFavoritesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productsIds = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productsIds)
    {
        $this->productsIds = $productsIds;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FavoriteProductService $favoriteProductService)
    {
        try {
            
            $checkExisting = $favoriteProductService->checkExistingFavoriteProducts($this->productsIds);

            if($checkExisting != false || is_array($checkExisting)){
                $ids = "";

                foreach ($checkExisting as $id) {
                    $ids .= $id.", "; 
                }

                throw new Exception("O produto(s) com Id(s): ".$ids." já foi favoritado! Nenhum item da lista será salvo!");
            }else{
                $shopifyService = new ShopifyService();
                $shopify = $shopifyService->getProductsByIds($this->productsIds);

                foreach($shopify->products as $product){
                    $favoriteProductService->createFavoriteProductByShopifyProdut($product);
                    Log::info("Produto ID: ".$product->id ."foi salvo!");
                }
            }

            
        } catch (Exception $e) {
            // Tratar exceções, logar erros, etc.
            Log::info("Nenhum item da lista será salvo!");
            throw $e;
        }
        
        
    }
}
