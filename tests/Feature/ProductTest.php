<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_the_word_documentation_in_homepage()
    {
        $response = $this->get('/');
        $response->assertSee('Documentation');
        $response->assertStatus(200);
    }

    public function test_can_see_the_products_page()
    {
        // $response = $this->get('/products');
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products', Product::all());
        $response->assertSee('No se encontraron productos');
    }
}
