<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;

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
                    foreach(range(1, 30) as $index) {
                        $rand = Factory::create()->dateTimeBetween($startDate = 'now', $endDate = '+2 months', $timezone = 'UTC');
                        $start = new Carbon($rand);
                        $end = new Carbon($rand);
                        $start_time = $start->minute(0)->second(0);
                        $end_time = $end->add(1, 'hour')->minute(0)->second(0);
                        $weekday = $start->weekday();

                        \App\Models\Availability::create([
                            'teacher_id' => $teacher->id,
                            'start' => $start_time,
                            'end' => $end_time,
                            'weekday' => $weekday,
                        ]);
                    }
         		});
         	} elseif ($user->role == 'student') {
         		\App\Models\Student::factory(1)->create(['user_id' => $user->id]);
         	}
         	
         });
    }
}