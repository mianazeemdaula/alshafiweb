<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->text,
            'featured' => $this->faker->boolean,
            'category_id' => $this->faker->numberBetween(1, 10),
            'discount' => $this->faker->randomFloat(2, 1, 100),
            'vat' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->numberBetween(1, 100),
            'weight' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(),
            'extra_info' => $this->faker->text,
            'referr_discount' => $this->faker->numberBetween(1, 100),
            'referal_discount' => $this->faker->numberBetween(1, 100),
        ];
    }
}
