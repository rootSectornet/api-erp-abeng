<?php

namespace Tests\Unit;
use App\Models\Product;
use App\Models\ProductStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductStepTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_product_steps()
    {
        ProductStep::factory()->count(3)->create();

        $response = $this->getJson('/api/product-steps');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_list_product_steps_by_product_id()
    {
        $product = Product::factory()->create();
        ProductStep::factory()->create([
            'product_id' => $product->id,
            'rank' => 2
        ]);
        ProductStep::factory()->create([
            'product_id' => $product->id,
            'rank' => 1
        ]);

        $response = $this->getJson('/api/product-steps?product_id=' . $product->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_product_step()
    {
        $product = Product::factory()->create();
        $data = [
            'name' => 'Step 1',
            'notes' => 'Notes for step 1',
            'rank' => 1,
            'maxDuration' => 100,
            'product_id' => $product->id,
        ];

        $response = $this->postJson('/api/product-steps', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_show_a_product_step()
    {
        $productStep = ProductStep::factory()->create();

        $response = $this->getJson('/api/product-steps/' . $productStep->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_product_step()
    {
        $productStep = ProductStep::factory()->create();
        $data = [
            'name' => 'Updated Step',
            'notes' => 'Updated notes',
            'rank' => 2,
            'maxDuration' => 200,
            'product_id' => $productStep->product_id,
        ];

        $response = $this->putJson('/api/product-steps/' . $productStep->id, $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_a_product_step()
    {
        $productStep = ProductStep::factory()->create();

        $response = $this->deleteJson('/api/product-steps/' . $productStep->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('product_steps', ['id' => $productStep->id]);
    }
}
