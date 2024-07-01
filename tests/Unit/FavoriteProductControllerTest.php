<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\FavoriteProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Services\FavoriteProductService;
use App\Http\Requests\RegisterFavoriteProductsRequest;
use Exception;

use Laravel\Passport\Passport;

class FavoriteProductControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_list_favorite_products()
    {
        // Autenticar o usuário usando Passport
        Passport::actingAs($this->user);

        $favoriteProduct = FavoriteProduct::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/favorite-products');
        $response->dump();
        $response->assertStatus(200);
        // $response->assertJsonFragment(['id' => $favoriteProduct->id]);
    }

    /** @test */
    public function it_can_filter_favorite_products_by_name()
    {
        Passport::actingAs($this->user);

        $favoriteProduct = FavoriteProduct::factory()->create(['user_id' => $this->user->id, 'title' => 'Test Product']);
        $anotherProduct = FavoriteProduct::factory()->create(['user_id' => $this->user->id, 'title' => 'Another Product']);

        $response = $this->getJson('/api/favorite-products?name=Test');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $favoriteProduct->id]);
        $response->assertJsonMissing(['id' => $anotherProduct->id]);
    }

    /** @test */
    public function it_can_add_products_to_favorites_batch()
    {
        Passport::actingAs($this->user);

        $response = $this->postJson('/api/favorite-products/batch', [
            'product_shopify_ids' => [4543367512203, 7413341782155],
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Os produtos foram enviados para a fila de favoritos!']);
    }

    /** @test */
    public function it_can_destroy_favorite_product()
    {
        Passport::actingAs($this->user);

        $favoriteProduct = FavoriteProduct::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/favorite-products/{$favoriteProduct->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Produto deletado com sucesso!']);
    }
}
