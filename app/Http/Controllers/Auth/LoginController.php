<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\App;
use App\Models\Student;
use App\Models\Teacher;
use Session;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Redirect the user to the Providers authentication page.
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
	    $isTeacher = request()->input('teacher');
	    $userRole = 'student';

	    if ($isTeacher === "true") {
		    $userRole = "teacher";
	    }

	    Session::put('user_role', $userRole);
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the Provider.
     *
     * @param $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($provider)
    {
        $socialite_user = Socialite::driver($provider)->user();

        $user = User::where('provider_id', $socialite_user->getId())->first();
		$userRole = Session::get('user_role');

        if (!$user) {
            $user = User::create([
                'email' => $socialite_user->getEmail(),
                'first_name' => explode(' ', $socialite_user->getName())[0],
                'last_name' => explode(' ', $socialite_user->getName())[1],
                'provider_id' => $socialite_user->getId(),
                'role' => $userRole,
                'currency' => 'HUF',
                'site_language' => App::getLocale(),
                'timezone' => 'Europe/Budapest'
                //'token' => $user->token
            ]);

            if ($userRole === 'teacher') {
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
                    'wanted_language' => 'en'
                ]);
            }
        }

        Session::forget('user_role');

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}

