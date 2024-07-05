<?php

namespace Tests\Unit;

use App\Models\Position;
use App\Models\Salary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalaryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_salarys()
    {
        Salary::factory()->count(3)->create();

        $response = $this->getJson('/api/salarys');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_list_salarys_by_position_id()
    {
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();

        Salary::factory()->create(['position_id' => $position1->id]);
        Salary::factory()->create(['position_id' => $position1->id]);
        Salary::factory()->create(['position_id' => $position2->id]);

        $response = $this->getJson('/api/salarys?position_id=' . $position1->id);

        $response->assertStatus(200);
    }


    /** @test */
    public function it_can_create_a_salary()
    {
        $position = Position::factory()->create();
        $data = [
            'type' => 'Hourly',
            'salary' => '5000',
            'position_id' => $position->id,
            'is_active' => true,
        ];

        $response = $this->postJson('/api/salarys/', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_show_a_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->getJson('/api/salarys/' . $salary->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_salary()
    {
        $salary = Salary::factory()->create();
        $data = [
            'type' => 'Updated Type',
            'salary' => '6000',
            'position_id' => $salary->position_id,
            'is_active' => false,
        ];

        $response = $this->putJson('/api/salarys/' . $salary->id, $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_a_salary()
    {
        $salary = Salary::factory()->create();

        $response = $this->deleteJson('/api/salarys/' . $salary->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('salarys', ['id' => $salary->id]);
    }
}
