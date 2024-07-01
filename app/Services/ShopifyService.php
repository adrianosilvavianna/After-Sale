<?php

namespace App\Services;

use App\Exceptions\NullVariableException;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

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

    public function getProductsByIds($listIds = null)
    {
        try {
            $endpoint = $this->apiUrl . '/admin/api/2020-01/products.json';
            
            if(is_array($listIds) || !is_null($listIds)){
                $ids = "";
                foreach($listIds as $id){
                    $ids .= $id.", ";
                }
                $endpoint .= '?ids=' . $ids;
            }
            
            $response = $this->client->request('GET', $endpoint);
            
            return json_decode($response->getBody()->getContents());

        } catch (ClientException $exception) {
            return $this->validateExceptionResponseStatusCode($exception);
        }

    }

    public function getProductById($productId)
    {
        try {

            $endpoint = $this->apiUrl . "/admin/api/2020-01/products/{$productId}.json";
            $response = $this->client->request('GET', $endpoint);
        
            return json_decode($response->getBody()->getContents());
            
        } catch (ClientException $exception) {
            return $this->validateExceptionResponseStatusCode($exception);
        }
        
    }

    protected function validateExceptionResponseStatusCode($exception){

        $response = $exception->getResponse();

        if ($response !== null) {
            $statusCode = $response->getStatusCode();

            if($statusCode == 404){
                $e = new NullVariableException("ID inválido - Produto não encontrado na API do Shopify");
                return $e->getMessage();
            }else {
                $responseData = json_decode($response->getBody()->getContents(), true);
            
                if (isset($responseData['errors'])) {
                    $errors = $responseData['errors'];
                    return response()->json(['error' => "Erro $statusCode: " . $errors]);
                }
            }

        } else {
            // Lidar com o caso em que não há resposta do servidor
            return response()->json(['error_status_code' => $response->getStatusCode()]);
        }
    }
        
   
}