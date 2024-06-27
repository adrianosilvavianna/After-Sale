<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ShopifyService
{
    protected $apiUrl;
    protected $apiKey;
    protected $apiPassword;
    protected $client;

    public function __construct()
    {
        $this->apiUrl = env('SHOPIFY_API_URL');
        $this->apiKey = env('SHOPIFY_API_KEY');
        $this->apiPassword = env('SHOPIFY_API_PASSWORD');

        $this->client = new Client([
            'verify' => false, // Desativa a verificação SSL / Não recomendado em produção
            'auth' => [$this->apiKey, $this->apiPassword],
        ]);
    }

    public function getProductsByIds($ids = null)
    {
        $endpoint = $this->apiUrl . '/admin/api/2020-01/products.json';
        
        if ($ids) {
            $endpoint .= '?ids=' . $ids;
        }
        
        $response = $this->client->request('GET', $endpoint);
        return $response->getBody()->getContents();

    }

    public function getProductById($productId)
    {
        $endpoint = $this->apiUrl . "/admin/api/2020-01/products/{$productId}.json";
        $response = $this->client->request('GET', $endpoint);
        return $response->getBody()->getContents();
    }

    public function createProduct(array $data)
    {
        $endpoint = $this->apiUrl . '/admin/api/2020-01/products.json';
        $response = $this->client->request('POST', $endpoint, $data);
        return $response->getBody()->getContents();
    }

    public function updateProduct($productId, array $data)
    {
        $endpoint = $this->apiUrl . "/admin/api/2020-01/products/{$productId}.json";
        $response = $this->client->request('PUT', $endpoint, $data);
        return $response->getBody()->getContents();
    }

    // public function deleteProduct($productId)
    // {
    //     $endpoint = $this->apiUrl . "/admin/api/2020-01/products/{$productId}.json";
    //     $response = Http::withBasicAuth($this->apiKey, $this->apiPassword)->delete($endpoint);
    //     return $response->json();
    // }

    // public function countProducts()
    // {
    //     $endpoint = $this->apiUrl . '/admin/api/2020-01/products/count.json';
    //     $response = Http::withBasicAuth($this->apiKey, $this->apiPassword)->get($endpoint);
    //     return $response->json();
    // }
}