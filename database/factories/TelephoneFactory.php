<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Telephone;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Telephone>
 */
class TelephoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Telephone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['iPhone', 'Samsung', 'Google Pixel']),
            'model' => $this->faker->word,
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'image' => 'default.jpg', // You can change this
        ];
    }
}
