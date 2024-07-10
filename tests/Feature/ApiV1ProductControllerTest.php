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
        $products = Product::factory()->count(3)->create();

        // Cuando
        $response = $this->get('/api/v1/product/get-all');

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'name', 'description', 'price', 'stock', 'created_at', 'updated_at'],
            ],
        ]);

        // Verificación de que en products exista la data creada
        foreach ($products as $product) {
            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
            ]);
        }

        // Obtener los productos desde la base de datos
        $productsFromDb = Product::orderBy('id', 'asc')->get();

        // Verificar que el orden de los productos creados coincida con el orden en la base de datos
        foreach ($products as $index => $product) {
            $this->assertEquals($product->id, $productsFromDb[$index]->id);
        }

    }

    public function test_show_product_success()
    {
        // Dato
        $product = Product::factory()->create();

        // Cuando
        $response = $this->get("/api/v1/product/get-one/{$product->id}");

        // Se espera qué
        $response->assertStatus(200);

        // Verificar estructura del JSON
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'description',
                'price',
                'stock',
                'created_at',
                'updated_at',
            ],
        ]);

        // Verificar contenido del JSON
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product found.',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (string) $product->price, // Convertir a cadena
                'stock' => $product->stock,
                'created_at' => $product->created_at->toJSON(), // Convertir a cadena
                'updated_at' => $product->updated_at->toJSON(), // Convertir a cadena
            ],
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
        $response = $this->post('/api/v1/product/register', $data);

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully created product.',
            'data' => $data,
        ]);

        // Verificación de que en products exista la data creada
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
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully updated product.',
            'data' => $data,
        ]);

        // Verificación de que en products exista la data creada
        $this->assertDatabaseHas('products', $data);
    }

    public function test_delete_product_success()
    {
        // Crear un producto de prueba
        $product = Product::factory()->create();

        // Cuando
        $response = $this->delete("/api/v1/product/delete/{$product->id}");

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully deleted product.',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (string) $product->price, // Convertir a cadena
                'stock' => $product->stock,
                'created_at' => $product->created_at->format('Y-m-d H:i:s'), // Formatear sin milisegundos
                'updated_at' => $product->updated_at->format('Y-m-d H:i:s'), // Formatear sin milisegundos
            ],
        ]);

        // Verificar que ya no exista el registro
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
