<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Product;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed your database or create test data as needed
    }

    /** @test */
    public function it_can_store_comment_for_post()
    {
        // Create a user (assuming you have a User model)
        $user = User::factory()->create();

        // Create a post (assuming you have a Post model)
        $post = Post::factory()->create();

        // Authenticate the user
        Auth::login($user);

        // Make a POST request to store a comment for the post
        $response = $this->post("/api/posts/{$post->id}/comments", [
            'body' => 'This is a test comment for the post.',
        ]);

        // Assert the response status is 201 (created)
        $response->assertStatus(201);

        // Assert the comment was created in the database
        $this->assertDatabaseHas('comments', [
            'body' => 'This is a test comment for the post.',
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_can_store_comment_for_product()
    {
        // Create a user (assuming you have a User model)
        $user = User::factory()->create();

        // Create a product (assuming you have a Product model)
        $product = Product::factory()->create();

        // Authenticate the user
        Auth::login($user);

        // Make a POST request to store a comment for the product
        $response = $this->post("/api/products/{$product->id}/comments", [
            'body' => 'This is a test comment for the product.',
        ]);

        // Assert the response status is 201 (created)
        $response->assertStatus(201);

        // Assert the comment was created in the database
        $this->assertDatabaseHas('comments', [
            'body' => 'This is a test comment for the product.',
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'user_id' => $user->id,
        ]);
    }
}
