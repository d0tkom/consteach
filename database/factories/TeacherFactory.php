<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'about_me' => [['locale' => 'hu', 'text' => $this->faker->text($maxNbChars = 500)], ['locale' => 'en', 'text' => $this->faker->text($maxNbChars = 500)]],
            'teaching_languages' => $this->makeLangs(),
            'country' => 'HU',
            'video_url' => 'https://www.youtube.com/embed/hGIW2fDb0jg',
            'one_hour_price' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'five_hour_price' => $this->faker->numberBetween($min = 5000, $max = 45000),
            'ten_hour_price' => $this->faker->numberBetween($min = 10000, $max = 90000),
        ];
    }

    public function makeLangs() {
        $levels = ['C1', 'C2', 'native'];
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