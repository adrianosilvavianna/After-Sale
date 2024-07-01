<?php

namespace App\Rules;

use App\Models\FavoriteProduct;
use Illuminate\Contracts\Validation\Rule;

class UniqueProductFavorite implements Rule
{
    protected $userId;
    protected $shopifyProductId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId, $shopifyProductId)
    {
        $this->userId = $userId;
        $this->shopifyProductId = $shopifyProductId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        dd(!FavoriteProduct::where('user_id', $this->userId)->where('shopify_product_id', $this->shopifyProductId)->get());
                                
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O usuário já adicionou este produto aos favoritos.';
    }
}
