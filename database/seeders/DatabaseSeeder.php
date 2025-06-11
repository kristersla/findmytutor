<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 fixed subjects
        $subjects = \App\Models\Subject::factory()->count(5)->create();

        // Create 10 tutors
        \App\Models\TutorProfile::factory(10)->create()->each(function ($profile) use ($subjects) {
            // Attach random subjects to each tutor
            $profile->subjects()->attach($subjects->random(2));

            // Create 2-3 reviews for each tutor
            \App\Models\Review::factory(rand(2, 3))->create([
                'tutor_profile_id' => $profile->id,
            ]);

            // Create 2 availability slots
            \App\Models\AvailabilitySlot::factory(2)->create([
                'tutor_profile_id' => $profile->id,
            ]);

            // Create a few sessions with students
            \App\Models\Session::factory(2)->create([
                'tutor_profile_id' => $profile->id,
            ]);
        });
    }

}
