<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_list_of_posts()
    {
        $response = $this->get(config('constants.API_POST_PATH'));
        $response->assertStatus(200);
        
    }

    public function test_can_create_posts()
    {
        $category = Category::factory()->create();
        $data = [
            'title' => 'Example Post Title',
            'feature_image_url' => 'https://placehold.co/600x400',
            'status' => 1,
            'category_id' => $category->id,
            'description' => 'This is an example description of the post.'
        ];
        $response = $this->post(config('constants.API_POST_PATH'), $data);
        $response->assertStatus(201);

    }

    public function test_can_get_post_by_id()
    {
        Category::factory()->create();
        $post = Post::factory()->create();
        $response = $this->get(config('constants.API_POST_PATH') . $post->id);
        $response->assertStatus(200);

    }

    public function test_can_update_post()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create();
        $data = [
            'title' => 'Example Post Title Updated',
            'feature_image_url' => 'https://placehold.co/600x400',
            'status' => 1,
            'category_id' => $category->id,
            'description' => 'This is an example description of the post.'
        ];
        $response = $this->put(config('constants.API_POST_PATH') . $post->id, $data);
        $response->assertStatus(201);

    }

    public function test_can_delete_post()
    {
        Category::factory()->create();
        $post = Post::factory()->create();
        $response = $this->delete(config('constants.API_POST_PATH') . $post->id);
        $response->assertStatus(204);

    }
}