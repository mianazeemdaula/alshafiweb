<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 2),
            'blog_category_id' => $this->faker->numberBetween(1, 2),
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'image' => $this->faker->imageUrl(),
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => $this->faker->sentence,
            'meta_title' => $this->faker->sentence,
            'meta_image' => $this->faker->imageUrl(),
        ];
    }
}
