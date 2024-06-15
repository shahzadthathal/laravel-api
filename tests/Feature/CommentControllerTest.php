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

    }

    /** @test */
    public function it_can_store_comment_for_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        Auth::login($user);
        $response = $this->post("/api/posts/{$post->id}/comments", [
            'body' => 'This is a test comment for the post.',
        ]);
        $response->assertStatus(201);
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
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Auth::login($user);
        $response = $this->post("/api/products/{$product->id}/comments", [
            'body' => 'This is a test comment for the product.',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'body' => 'This is a test comment for the product.',
            'commentable_id' => $product->id,
            'commentable_type' => Product::class,
            'user_id' => $user->id,
        ]);

    }
}
