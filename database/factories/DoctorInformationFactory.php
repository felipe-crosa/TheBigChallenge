<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorInformation>
 */
class DoctorInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'speciality' => $this->faker->name(),
            'institution' => $this->faker->company(),
            'user_id' => User::factory()->create(),
        ];
    }
}
