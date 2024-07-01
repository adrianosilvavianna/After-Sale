<?php

namespace App\Http\Requests;

use App\Rules\UniqueProductFavorite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterFavoriteProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shopify_product_id' => 'required|int',
            // 'shopify_product_id.*' => ['required', 'integer', 'exists:favorite_products,shopify_product_id', new UniqueProductFavorite(auth()->user()->id, $this->shopify_product_id)],
            
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'shopify_product_id.required' => 'O id do produto que vem da API do Shopify é obrigatório.',
        ];
    }

    /**
     * Failed Validator return exceptions messages
     *
     * @param  Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $errors
        ], 422));
    }   
}
