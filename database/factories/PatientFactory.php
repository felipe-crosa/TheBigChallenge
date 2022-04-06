<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'height' => $this->faker->randomFloat(2, 50, 230),
            'date_of_birth' => $this->faker->date(),
            'weight' => $this->faker->randomFloat(2, 1, 500),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'allergies' => $this->faker->paragraph,
            'medical_conditions' =>$this->faker->paragraph,
            'user_id'=>User::factory()->create(),
        ];
    }
}
