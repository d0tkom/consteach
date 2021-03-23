<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

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
        session(['user_role' => request('teacher') ? 'teacher' : 'student']);
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

        if (!$user) {
            $user = User::create([
                'email' => $socialite_user->getEmail(),
                'first_name' => explode(' ', $socialite_user->getName())[0],
                'last_name' => explode(' ', $socialite_user->getName())[1],
                'provider_id' => $socialite_user->getId(),
                'role' => session('user_role'),
                'currency' => 'HUF',
                'site_language' => 'hu',
                'timezone' => 'Europe/Budapest'
                //'token' => $user->token
            ]);

            if (session('user_role') == 'teacher') {
                Teacher::create([
                    'user_id' => $user->id,
                    'completed' => false,
                    'validated' => false
                ]);
            } else {
                Student::create([
                    'user_id' => $user->id,
                    'wanted_language' => 'en'
                ]);
            }
        }

        session()->forget('user_role');

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}