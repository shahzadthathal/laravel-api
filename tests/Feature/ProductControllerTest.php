<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_list_of_products()
    {
        $response = $this->get(config('constants.API_PRODUCT_PATH'));
        $response->assertStatus(200);
    }

    public function test_can_create_product()
    {
        $category = Category::factory()->create();
        $data = [
            'title' => 'Example Product Title',
            'price' => 10,
            'stock_quantity' => 100,
            'summary' => 'Product summary',
            'feature_image_url' => 'https://placehold.co/600x400',
            'status' => 1,
            'category_id' => $category->id,
            'description' => 'This is an example description of the post.'
        ];
        $response = $this->post(config('constants.API_PRODUCT_PATH'), $data);
        $response->assertStatus(201);
    }

    public function test_can_get_product_by_id()
    {
        Category::factory()->create();
        $product = Product::factory()->create();
        $response = $this->get(config('constants.API_PRODUCT_PATH') . $product->id);
        $response->assertStatus(200);
    }

    public function test_can_update_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'title' => 'Example Product Title Updated',
            'price' => 10,
            'stock_quantity' => 100,
            'summary' => 'Product summary',
            'feature_image_url' => 'https://placehold.co/600x400',
            'status' => 1,
            'category_id' => $category->id,
            'description' => 'This is an example description of the post.'
        ];
        $response = $this->put(config('constants.API_PRODUCT_PATH') . $product->id, $data);
        $response->assertStatus(201);
    }

    public function test_can_delete_product()
    {
        Category::factory()->create();
        $product = Product::factory()->create();
        $response = $this->delete(config('constants.API_PRODUCT_PATH') . $product->id);
        $response->assertStatus(204);
    }
}