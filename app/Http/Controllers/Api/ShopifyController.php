<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShopifyService;
use Illuminate\Http\Request;


class ShopifyController extends Controller
{
    protected $shopify;

    public function __construct(ShopifyService $shopify)
    {
        $this->shopify = $shopify;
    }

    public function getProductsByIds(Request $request)
    {
        return $this->shopify->getProductsByIds($request->ids);
    }

    public function getProductById(Request $request)
    {
        return $this->shopify->getProductById($request->id);
    }

    public function getProductByName(Request $request){
        $data = $this->shopify->getProductsByIds();
        
        $collection = collect($data);
        
        dd($collection);
        // $filtered = $collection->filter(function ($item) {
        //     return $item['id'] > 1;
        // });
        
        // dd($filtered->values()->toArray());
    }
    
}
