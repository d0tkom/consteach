<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the Provider.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $socialite_user = Socialite::driver($provider)->user();

        $user = User::where('provider_id', $socialite_user->getId())->first();

        if (!$user) {
            $user = User::create([
                'email' => $socialite_user->getEmail(),
                'name' => $socialite_user->getName(),
                'username' => $socialite_user->getNickname(),
                'provider_id' => $socialite_user->getId(),
                'role' => 'teacher',
                //'token' => $user->token
            ]);
        }

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}