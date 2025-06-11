<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tutor_profile_id' => \App\Models\TutorProfile::factory(),
            'student_user_id' => \App\Models\User::factory(),
            'datetime' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'duration' => $this->faker->randomElement([30, 60, 90]),
            'status' => 'pending',
            'location' => $this->faker->randomElement(['Online', $this->faker->address()]),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }

}
