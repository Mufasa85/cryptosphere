<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'client';
        $data['is_active'] = true;

        $user = User::create($data);
        $user->assignRole('client');

        event(new Registered($user));

        Mail::to($user)->queue(new WelcomeMail($user));
        // Envoi d’un email de bienvenue + email de vérification (URL à générer)
        $verificationUrl = url('/email/verify');
        Mail::to($user)->queue(new VerifyEmailMail($user, $verificationUrl));


        Auth::login($user);

        return redirect()->route('client.dashboard');
    }
}
