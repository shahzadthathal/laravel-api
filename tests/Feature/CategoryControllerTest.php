<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_list_of_categories()
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
    }

    public function test_can_create_category()
    {
        $data = [
            'name' => 'Test Category',
        ];

        $response = $this->post('/api/categories', $data);
        $response->assertStatus(201);
    }

    public function test_can_get_category_by_id()
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Category Name',
        ];

        $response = $this->put('/api/categories/' . $category->id, $data);
        $response->assertStatus(201);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete('/api/categories/' . $category->id);
        $response->assertStatus(204);
    }
}