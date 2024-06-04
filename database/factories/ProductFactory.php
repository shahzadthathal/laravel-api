<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\SlugTrait;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'price' => 20.00,
            'summary' => $this->faker->sentence(30),
            'description' => $this->faker->text,
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'feature_image_url' => 'https://placehold.co/600x400'
        ];
    }
}
