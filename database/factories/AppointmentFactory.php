<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'role' => $this->faker->randomElement(array('student', 'teacher')),
            'currency' => $this->faker->randomElement(array('HUF', 'USD', 'EUR')),
            'timezone' => $this->faker->timezone(),
            'spoken_languages' => $this->makeLangs(),
            'site_language' => $this->faker->randomElement(array('hu', 'en')),
            'is_night' => false,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'profile_photo_path' => '',
            'remember_token' => Str::random(10),
        ];
    }

    public function makeLangs() {
        $levels = ['A1', 'B1', 'A2', 'B2', 'C1', 'C2', 'native'];
        $language_array = ['hu', 'en', 'de', 'es', 'fr'];

        $languages = [];
        $i = 0;

        while ($i <= $this->faker->numberBetween($min = 1, $max = 3)) {
            $languages[] = ['level' => $this->faker->randomElement($levels), 'language' => $this->faker->randomElement($language_array)];
            $i++;
        }

        return $languages;
    }
}