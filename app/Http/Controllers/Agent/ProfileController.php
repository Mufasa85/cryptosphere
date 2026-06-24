<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('agent.profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ];

        if ($request->filled('email')) {
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,' . $user->id];
        }

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $data = $request->validate($rules);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        ActivityLog::record('profile.updated', $user, 'Profil agent mis à jour');

        return back()->with('success', 'Profil mis à jour.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'two_factor_enabled' => ! $user->two_factor_enabled,
        ]);

        ActivityLog::record('two_factor.toggled', $user, '2FA agent modifié');

        return back()->with(
            'success',
            $user->two_factor_enabled ? '2FA activé.' : '2FA désactivé.'
        );
    }
}
