<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\CategoryProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_products()
    {
        $category1 = CategoryProduct::factory()->create();
        $category2 = CategoryProduct::factory()->create();
        $productsCategory1 = Product::factory()->count(3)->create(['id_category' => $category1->id]);
        $productsCategory2 = Product::factory()->count(2)->create(['id_category' => $category2->id]);

        $response = $this->get('/api/products?id_category=' . $category1->id);

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');

        $response = $this->get('/api/products?id_category=' . $category2->id);

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data');
    }

    public function test_it_can_create_a_product()
    {
        $category = CategoryProduct::factory()->create();

        $data = [
            'name' => 'New Product',
            'id_category' => $category->id,
            'is_active' => true
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(200);
    }

    public function test_it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => 'Updated Product',
            'is_active' => false
        ];

        $response = $this->put("/api/products/{$product->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_it_can_show_a_product_with_category()
    {
        $category = CategoryProduct::factory()->create();
        $product = Product::factory()->create(['id_category' => $category->id]);

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(200);
    }
}
