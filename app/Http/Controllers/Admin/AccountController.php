<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function profile()
    {
        return view('admin.account.profile');
    }

    public function updateProfile(Request $request)
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

        ActivityLog::record('account.updated', $user, 'Profil mis à jour');

        return back()->with('success', 'Profil mis à jour.');
    }

    public function toggleTwoFactor()
    {
        $user = auth()->user();

        $user->update([
            'two_factor_enabled' => ! $user->two_factor_enabled,
        ]);

        ActivityLog::record('account.two_factor', $user, '2FA ' . ($user->two_factor_enabled ? 'activé' : 'désactivé'));

        return back()->with(
            'success',
            $user->two_factor_enabled ? '2FA activé.' : '2FA désactivé.'
        );
    }
}
