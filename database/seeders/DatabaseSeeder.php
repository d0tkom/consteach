<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(100)->create()->each(function ($user) {
         	if ($user->role == 'teacher') {
         		\App\Models\Teacher::factory(1)->create(['user_id' => $user->id])->each(function ($teacher) {

         			$start = Factory::create()->dateTimeBetween($startDate = 'now', $endDate = '+2 months', $timezone = $teacher->timezone);

         			\App\Models\Availability::factory(30)->create([
         				'teacher_id' => $teacher->id,
         				'start' => $start,
         				'end' => $start->modify('+1 hour'),
         				'weekday' => $start->format('w') + 1,
         			]);
         		});
         	} elseif ($user->role == 'student') {
         		\App\Models\Student::factory(1)->create(['user_id' => $user->id]);
         	}
         	
         });
    }
}