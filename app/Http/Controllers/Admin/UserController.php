<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->withCount('loanApplications')
            ->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('loanApplications');

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);

        ActivityLog::record('user.toggled', $user, 'Compte ' . ($user->is_active ? 'activé' : 'désactivé'));

        return back()->with('success', 'Statut du compte mis à jour.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->withErrors(['Impossible de supprimer un administrateur.']);
        }

        $user->delete();

        ActivityLog::record('user.deleted', null, 'Utilisateur ' . $user->email . ' supprimé');

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }
}
