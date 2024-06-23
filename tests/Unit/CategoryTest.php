<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CategoryProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_categories()
    {
        $categories = CategoryProduct::factory()->count(3)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_it_can_create_a_category()
    {
        $data = [
            'name' => 'New Category',
            'is_active' => true
        ];

        $response = $this->post('/api/categories', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('category_products', $data);
    }

    public function test_it_can_show_a_category()
    {
        $category = CategoryProduct::factory()->create();

        $response = $this->get("/api/categories/{$category->id}");

        $response->assertStatus(200);
    }

    public function test_it_can_update_a_category()
    {
        $category = CategoryProduct::factory()->create();

        $data = [
            'name' => 'Updated Category',
            'is_active' => false
        ];

        $response = $this->put("/api/categories/{$category->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('category_products', $data);
    }

    public function test_it_can_delete_a_category()
    {
        $category = CategoryProduct::factory()->create();

        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('category_products', ['id' => $category->id]);
    }
}
