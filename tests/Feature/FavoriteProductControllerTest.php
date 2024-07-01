<?php

namespace Tests\Feature;

use App\Models\FavoriteProduct;
use App\Models\User;
use App\Rules\UniqueProductFavorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteProductControllerTest extends TestCase
{
    // public function testRulePassesWhenProductIsNotFavorited()
    // {
    //     $user = User::factory()->create();
    //     $product = FavoriteProduct::factory()->create();

    //     $rule = new UniqueProductFavorite($user->id, $product->id);
    //     $this->assertTrue($rule->passes('product_id', $product->id));
    // }

    // public function testRuleFailsWhenProductIsAlreadyFavorited()
    // {
    //     $user = User::factory()->create();
    //     $product = Product::factory()->create();

    //     FavoriteProduct::create(['user_id' => $user->id, 'product_id' => $product->id]);

    //     $rule = new UniqueProductFavorite($user->id);
    //     $this->assertFalse($rule->passes('product_id', $product->id));
    // }

}
