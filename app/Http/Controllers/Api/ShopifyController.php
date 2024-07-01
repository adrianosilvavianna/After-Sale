<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShopifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $rules = ['id' => 'required|int'];

        $validator = Validator::make($request->all(), $rules, [
            'required' => 'O ID do produto é um campo obrigatório.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 500);
        }

        return $this->shopify->getProductById($request->id);
    }

    public function getProductByName(Request $request){

        $rules = ['name' => 'required|string|max:255'];

        $validator = Validator::make($request->all(), $rules, [
            'required' => 'O :attribute é um campo obrigatório.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 500);
        }

        $data = $this->shopify->getProductsByIds();
        $collection = collect($data->products);

        $name = $request->name;
        
        $filtered = $collection->filter(function ($item) use ($name) {
            return strpos($item->title, $name) !== false;
        });

        return response()->json($filtered);
    }

}
