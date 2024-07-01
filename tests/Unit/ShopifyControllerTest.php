<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Illuminate\Http\Request;
use Exception;

class ShopifyControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // Cria um usuário para autenticação
        $this->user = User::factory()->create();
    }

    public function testUnauthenticatedUserCannotAccessProducts()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401); // Não autorizado
        $response->assertJson(['error' => 'Unauthorized']);
    }

    public function testAuthenticatedUserCanAccessProducts()
    {
        Passport::actingAs($this->user);

        $response = $this->get('/api/user');
        // $response->dump();
        $response->assertStatus(200);
        $response->assertJson(['message' => 'User-Authorized']);
        
    }

    public function testGetProducts()
    {
        Passport::actingAs($this->user);

        $response = $this->getJson('/api/shopify/getProductsByIds');
        
        $response->assertStatus(200);
        // $response->dump();
    }

    public function testGetProductsByIds()
    {
        Passport::actingAs($this->user);

        $params = ['4543371706507', '4543373377675'];

        $response = $this->getJson('/api/shopify/getProductsByIds', ['ids' => $params]);
        
        $response->assertStatus(200);

        
        // $response->dump();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }
}
