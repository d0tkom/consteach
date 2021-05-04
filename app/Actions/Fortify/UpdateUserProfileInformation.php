<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use App\Models\Teacher;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:2048'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'timezone' => $input['timezone'],
                'spoken_languages' => $input['spoken_languages'] ?? [],
                'site_language' => $input['site_language'] ?? 'hu',
                'currency' => $input['currency'] ?? 'HUF',
            ])->save();
        }

        if ($user->role == 'teacher') {
            Validator::make($input, [
                'one_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0'],
            ])->validateWithBag('updateProfileInformation');

            Validator::make($input, [
                'five_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$input['one_hour_price']*5],
                'ten_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$input['one_hour_price']*10],
                'twenty_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$input['one_hour_price']*20],
            ])->validateWithBag('updateProfileInformation');

            $teacher = Teacher::where('user_id', $user->id)->first();

            $teacher->teaching_languages = $input['teaching_languages'];
            $teacher->about_me = $input['about_me'];
            $teacher->country = $input['country'];
            $teacher->complete = $input['complete'] ?? $teacher->complete;
            $teacher->video_url = $input['video_url'];
            $teacher->one_hour_price = $input['one_hour_price'] ?? 0;
            $teacher->five_hour_price = $input['five_hour_price'] ?? 0;
            $teacher->ten_hour_price = $input['ten_hour_price'] ?? 0;
            $teacher->twenty_hour_price = $input['twenty_hour_price'] ?? 0;

            $teacher->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}