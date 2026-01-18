<?php

namespace Database\Factories;

use App\Models\Category;
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
        $date = $this->faker->dateTimeBetween('-10 years', 'now');

        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2,1000, 10000),
            'category_id' => $this->faker->numberBetween(1, 10),
            'in_stock' => $this->faker->boolean(),
            'rating' => $this->faker->randomFloat(1,1, 5),
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
