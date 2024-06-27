<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiV1ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_products_success()
    {
        // Dato
        Product::factory()->count(3)->create();

        // Cuando
        $response = $this->get('/api/v1/product/get-all');

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'price', 'stock', 'created_at', 'updated_at'],
        ]);
    }

    public function test_show_product_success()
    {
        // Dato
        $product = Product::factory()->create();

        // Cuando
        $response = $this->get("/api/v1/product/show/{$product->id}");

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
        ]);
    }

    public function test_create_product_success()
    {
        // Dato
        $data = [
            'name' => 'Producto Test',
            'description' => 'Descripción Test',
            'price' => 99,
            'stock' => 10,
        ];

        // Cuando
        $response = $this->post('/api/v1/product/create', $data);

        // Se espera qué
        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $data,
        ]);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product_success()
    {
        // Crear un producto de prueba
        $product = Product::factory()->create();

        // Dato
        $data = [
            'name' => 'Producto Actualizado',
            'description' => 'Descripción Actualizada',
            'price' => 199,
            'stock' => 20,
        ];

        // Cuando
        $response = $this->put("/api/v1/product/update/{$product->id}", $data);

        // Se espera qué
        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $data,
        ]);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_delete_product_success()
    {
        // Crear un producto de prueba
        $product = Product::factory()->create();

        // Cuando
        $response = $this->delete("/api/v1/product/delete/{$product->id}");

        // Se espera qué
        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => "ID: {$product->id}",
        ]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
