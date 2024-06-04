<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed comments for posts
        $posts = Post::all();
        $users = User::all();
        foreach ($posts as $post) {
            foreach (range(1, 5) as $index) {
                Comment::factory()->create([
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                    'user_id' => $users->random()->id,
                    'body' => 'This is a comment on post ' . $post->id . ', comment number ' . $index,
                ]);
            }
        }

        // Seed comments for products
        $products = Product::all();
        foreach ($products as $product) {
            foreach (range(1, 5) as $index) {
                Comment::factory()->create([
                    'commentable_id' => $product->id,
                    'commentable_type' => Product::class,
                    'user_id' => $users->random()->id,
                    'body' => 'This is a comment on product ' . $product->id . ', comment number ' . $index,
                ]);
            }
        }
    }
}
