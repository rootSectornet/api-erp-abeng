<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_materials()
    {
        $materials = Material::factory()->count(3)->create();

        $response = $this->get('/api/materials');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_material()
    {
        $data = [
            'name' => 'New Material',
            'price' => '10.50',
            'unit' => 'kg',
            'type' => 'BERAT',
            'is_active' => true
        ];

        $response = $this->post('/api/materials', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('materials', $data);
    }

    public function test_it_can_show_a_material()
    {
        $material = Material::factory()->create();

        $response = $this->get("/api/materials/{$material->id}");

        $response->assertStatus(200);
    }

    public function test_it_can_update_a_material()
    {
        $material = Material::factory()->create();

        $data = [
            'name' => 'Updated Material',
            'price' => '15.75',
            'unit' => 'g',
            'type' => 'RINGAN',
            'is_active' => false
        ];

        $response = $this->put("/api/materials/{$material->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('materials', $data);
    }

    public function test_it_can_delete_a_material()
    {
        $material = Material::factory()->create();

        $response = $this->delete("/api/materials/{$material->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('materials', ['id' => $material->id]);
    }
    public function test_it_can_search_materials_by_name()
    {
        Material::factory()->create(['name' => 'Material 1']);
        Material::factory()->create(['name' => 'Material 2']);
        Material::factory()->create(['name' => 'Another Material']);

        $response = $this->get('/api/search/materials?name=Material');

        $response->assertStatus(200);
    }
}
