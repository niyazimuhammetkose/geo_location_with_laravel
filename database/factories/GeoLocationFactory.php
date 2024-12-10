<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeoLocation>
 */
class GeoLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => fake()->numberBetween(1, 10),
            'name' => fake()->word . " Location",
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'marker_color' => fake()->hexColor,
        ];
    }

    /**
     * Indicate that the model should be deleted.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
            'deleted_by' => fake()->numberBetween(1, 10),
        ]);
    }

    /**
     * Indicate that the model should be updated.
     */
    public function updated(): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_at' => now(),
            'updated_by' => fake()->numberBetween(1, 10),
        ]);
    }

}
