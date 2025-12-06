<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    const REDIRECT = 'redirect';
    const HANDLE_CALLBACK = 'handleCallback';
    const DESTROY = 'destroy';

    public function handleCallback(): \Illuminate\Http\RedirectResponse
    {
        try {
            $googlePayload = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect('/');
        }

        $existingUser = User::where('email', $googlePayload->email)->first();
        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            if (!str_contains($googlePayload->email, 'hermine.global')) abort(403);
            
            $newUser = new User(
                [
                    'name' => $googlePayload->name,
                    'email' => $googlePayload->email,
                    'google_id' => $googlePayload->id,
                    'hd' => $googlePayload->user['hd'],
                    'avatar' => $googlePayload->avatar,
                ]
            );
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect('/iz/needlist');
    }

    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
