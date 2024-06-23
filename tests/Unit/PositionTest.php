<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_positions()
    {
        $positions = Position::factory()->count(3)->create();

        $response = $this->get('/api/positions');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_position()
    {
        $data = [
            'name' => 'New Position',
            'is_active' => true
        ];

        $response = $this->post('/api/positions', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('positions', $data);
    }

    public function test_it_can_show_a_position()
    {
        $position = Position::factory()->create();

        $response = $this->get("/api/positions/{$position->id}");

        $response->assertStatus(200);
    }

    public function test_it_can_update_a_position()
    {
        $position = Position::factory()->create();

        $data = [
            'name' => 'Updated Position',
            'is_active' => false
        ];

        $response = $this->put("/api/positions/{$position->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('positions', $data);
    }

    public function test_it_can_delete_a_position()
    {
        $position = Position::factory()->create();

        $response = $this->delete("/api/positions/{$position->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('positions', ['id' => $position->id]);
    }
}
