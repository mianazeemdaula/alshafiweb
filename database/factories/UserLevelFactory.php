<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserLevel>
 */
class UserLevelFactory extends Factory
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
            'min_points' => $this->faker->randomNumber(2),
            'discount' => $this->faker->randomNumber(2),
            'cashback' => $this->faker->randomNumber(2),
        ];
    }
}
