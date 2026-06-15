<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $provider_user = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            [
                'provider_id' => $provider_user->getId(),
                'provider_name' => $provider,
                'provider_avatar' => $provider_user->getAvatar(),
                'password' => bcrypt(str()->random(16)),
            ],
            [
                'name' => $provider_user->getName(),
                'email' => $provider_user->getEmail(),
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }
}
