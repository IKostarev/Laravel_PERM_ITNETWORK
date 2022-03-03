<?php

namespace Database\Factories;

use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $create_at = $this->faker->dateTimeBetween('-1 year');
        return [
            'name' => $this->faker->city(),
            'created_at' => $create_at,
            'updated_at' => $this->faker->dateTimeBetween($create_at),
        ];
    }
}
