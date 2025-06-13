<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $subjects = \App\Models\Subject::factory()->count(5)->create();


        \App\Models\TutorProfile::factory(10)->create()->each(function ($profile) use ($subjects) {

            $profile->subjects()->attach($subjects->random(2));

            \App\Models\Review::factory(rand(2, 3))->create([
                'tutor_profile_id' => $profile->id,
            ]);

            \App\Models\AvailabilitySlot::factory(2)->create([
                'tutor_profile_id' => $profile->id,
            ]);

            \App\Models\Session::factory(2)->create([
                'tutor_profile_id' => $profile->id,
            ]);
        });
    }

}
