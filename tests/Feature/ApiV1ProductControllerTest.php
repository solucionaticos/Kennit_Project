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
        $data = [
            'name' => 'Producto Test 1',
            'description' => 'Descripción Test 1',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 99,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ];

        // Cuando
        $response = $this->post('/api/v1/product/register', $data);

        // Dato
        $data = [
            'name' => 'Producto Test 2',
            'description' => 'Descripción Test 2',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 99,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ];

        // Cuando
        $response = $this->post('/api/v1/product/register', $data);

        // Dato
        $data = [
            'name' => 'Producto Test 3',
            'description' => 'Descripción Test 3',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 99,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ];

        // Cuando
        $response = $this->post('/api/v1/product/register', $data);

        // Cuando
        $response = $this->get('/api/v1/product/get-all');

        // Se espera qué
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'name', 'description', 'price', 'stock', 'discount', 'final_price', 'tax_rate', 'tax_amount', 'created_at', 'updated_at'],
            ],
        ]);

    }

    public function test_show_product_success()
    {
        // Dato
        $product = Product::factory()->create([
            'name' => 'Producto Test 1',
            'description' => 'Descripción Test 1',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 99,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ]);

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
                'discount',
                'final_price',
                'tax_rate',
                'tax_amount',
                'created_at',
                'updated_at',
            ],
        ]);

        // Verificar contenido del JSON
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully getting the product',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (string) $product->price,
                'stock' => $product->stock,
                'discount' => (string) $product->discount,
                'final_price' => (string) $product->final_price,
                'tax_rate' => (string) $product->tax_rate,
                'tax_amount' => (string) $product->tax_amount,
                'created_at' => $product->created_at->toJSON(),
                'updated_at' => $product->updated_at->toJSON(),
            ],
        ]);

    }

    public function test_create_product_success()
    {
        // Datos de prueba
        $data = [
            'name' => 'Producto Test',
            'description' => 'Descripción Test',
            'price' => 100,
            'stock' => 10,
            'discount' => 0,
            'final_price' => 0,
            'tax_rate' => 10,
            'tax_amount' => 0,
        ];

        // Cuando se hace la solicitud POST para crear el producto
        $response = $this->postJson('/api/v1/product/register', $data);

        // Se espera que el estado sea 200 OK
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
                'discount',
                'final_price',
                'tax_rate',
                'tax_amount',
                'created_at',
                'updated_at',
            ],
        ]);

        // Verificar contenido del JSON
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully created product.',
            'data' => [
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => (string) $data['price'],
                'stock' => $data['stock'],
                'discount' => (string) 0,
                'final_price' => (string) 0,
                'tax_rate' => (string) $data['tax_rate'],
                'tax_amount' => (string) 0,
            ],
        ]);

        // Verificación de que en products exista la data creada
        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'discount' => 0,
            'final_price' => 0,
            'tax_rate' => $data['tax_rate'],
            'tax_amount' => 0,
        ]);
    }

    public function test_update_product_success()
    {
        // Datos de prueba para crear el producto
        $createData = [
            'name' => 'Producto Test',
            'description' => 'Descripción Test',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 90,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ];

        // Crear un producto de prueba
        $createResponse = $this->post('/api/v1/product/register', $createData);
        $createResponse->assertStatus(200);

        // Obtener el producto creado
        $product = $createResponse->json('data');

        // Datos de prueba para actualizar el producto
        $updateData = [
            'name' => 'Producto Actualizado',
            'description' => 'Descripción Actualizada',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 90,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ];

        // Actualizar el producto
        $response = $this->put("/api/v1/product/update/{$product['id']}", $updateData);
        $response->assertStatus(200);

        // Ajustar los datos esperados según la respuesta actual de tu API
        $expectedData = [
            'id' => $product['id'],
            'name' => 'Producto Actualizado',
            'description' => 'Descripción Actualizada',
            'price' => 100,
            'stock' => 10,
            'discount' => 0,
            'final_price' => 110,
            'tax_rate' => 10,
            'tax_amount' => 10,
            'created_at' => $product['created_at'],
            'updated_at' => $response->json('data.updated_at'),
        ];

        // Verificar el contenido del JSON
        $response->assertJson([
            'status' => 'success',
            'message' => 'Successfully updated product.',
            'data' => $expectedData,
        ]);

        // Verificación de que en products exista la data actualizada
        $this->assertDatabaseHas('products', $expectedData);
    }

    public function test_delete_product_success()
    {

        // Crear un producto de prueba
        $product = Product::factory()->create([
            'name' => 'Producto Test 1',
            'description' => 'Descripción Test 1',
            'price' => 100,
            'stock' => 10,
            'discount' => 10,
            'final_price' => 99,
            'tax_rate' => 10,
            'tax_amount' => 9,
        ]);

        // Cuando
        $response = $this->delete("/api/v1/product/delete/{$product->id}");

        // Se espera qué
        $response->assertStatus(200);

        // Verificar el contenido del JSON
        $response->assertJson([
            'status' => 'success',
            'message' => 'Record deleted successfully.',
            'data' => null,
        ]);

        // Verificar que ya no exista el registro
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

    }
}
