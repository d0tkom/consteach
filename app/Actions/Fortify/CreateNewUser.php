<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        

        $user =  User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'country' => 'HU',
            'timezone' => 'UTC+0',
            'profile_photo_path' => '',
            'role' => isset($input['teacher']) ? 'teacher' : 'student',
            'password' => Hash::make($input['password']),
        ]);

        if (isset($input['teacher'])) {
            Teacher::create([
                'user_id' => $user->id,
                'about_me' => '',
                'teaching_languages' => json_encode(array()),
                'video_url' => '',
                'one_hour_price' => 0,
                'five_hour_price' => 0,
                'ten_hour_price' => 0,
            ]);
        } else {
            Student::create([
                'user_id' => $user->id,
                'wanted_language' => 'HU',
                'language' => 'HU',
                'is_night' => 0,
            ]);
        }

        return $user;
    }
}