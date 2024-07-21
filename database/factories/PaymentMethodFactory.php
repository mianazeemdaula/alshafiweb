<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'slug' => strtolower($this->faker->unique()->word()),
            'status' => $this->faker->randomElement([true, false]),
            'image' => $this->faker->imageUrl(),
            'config' => json_encode([
                'key' => $this->faker->word(),
                'secret' => $this->faker->word(),
            ]),
        ];
    }
}
