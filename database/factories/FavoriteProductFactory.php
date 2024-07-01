<?php

namespace Database\Factories;

use App\Models\FavoriteProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteProductFactory extends Factory
{
    protected $model = FavoriteProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence,
            'body_html' => $this->faker->sentence,
            'vendor' => $this->faker->sentence,
            'handle' => $this->faker->text,
            'shopify_product_id' => '4543367512203',
            'status' => 'Disponível',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
