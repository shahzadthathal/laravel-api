<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\SlugTrait;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    use SlugTrait;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        $slug = $this->generateSlug($title);
        // Get all category IDs
        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        
        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->text,
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'feature_image_url' => 'https://placehold.co/600x400'
        ];
    }
}
