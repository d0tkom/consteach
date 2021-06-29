<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\App;

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
	        'terms' => ['accepted'],
        ], [
	        'required' => __('auth.validation_required'),
	        'unique' => __('auth.validation_unique'),
	        'password.confirmed' => __('auth.validation_password'),
	        'accepted' => __('auth.validation_accepted'),
        ], [
	        'first_name' => __('auth.validation_first_name'),
	        'last_name' => __('auth.validation_last_name'),
	        'email' => __('auth.validation_email'),
	        'password' => __('auth.validation_password'),
        ])->validate();

        $role = $input['teacher'] ? 'teacher' : 'student';

        $user =  User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'currency' => 'HUF',
            'timezone' => 'Europe/Budapest',
            'site_language' => App::getLocale(),
            'profile_photo_path' => '',
            'role' => $role,
            'password' => Hash::make($input['password']),
        ]);

        if ($role == 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'about_me' => json_encode(array()),
                'country' => 'HU',
                'teaching_languages' => json_encode(array()),
                'video_url' => '',
                'one_hour_price' => 0,
                'five_hour_price' => 0,
                'ten_hour_price' => 0,
                'twenty_hour_price' => 0,
            ]);
        } else {
            Student::create([
                'user_id' => $user->id,
                'wanted_language' => 'hu',
            ]);
        }

        return $user;
    }
}