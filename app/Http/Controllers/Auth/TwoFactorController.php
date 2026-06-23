<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    public function showChallenge()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if (! $user instanceof User) {
            return redirect()->route('login');
        }

        if ($user->two_factor_code !== $request->input('code') || $user->two_factor_expires_at?->isPast()) {
            throw ValidationException::withMessages([
                'code' => ['Le code est invalide ou a expiré.'],
            ]);
        }

        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            default => redirect()->route('client.dashboard'),
        };
    }
}
