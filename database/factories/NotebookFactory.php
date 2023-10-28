<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notebook>
 */
class NotebookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $photo = Photo::factory()->create();

        return [
            'full_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'company' => $this->faker->unique()->name,
            'birthdate' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'photo_id' => $photo->id,
        ];
    }
}
