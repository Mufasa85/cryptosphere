<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Ces identifiants ne correspondent pas à nos enregistrements.'],
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Votre compte a été désactivé.'],
            ]);
        }

        if ($user->two_factor_enabled) {
            $user->update([
                'two_factor_code' => random_int(100000, 999999),
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($user)->queue(new TwoFactorCodeMail($user));

            return redirect()->route('two-factor.challenge');
        }

        return $this->redirectByRole($user);
    }

    protected function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            default => redirect()->route('client.dashboard'),
        };
    }
}
