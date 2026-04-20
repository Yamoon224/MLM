<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Liste tous les utilisateurs (hors admins).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $users = User::when($search, function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Affiche le formulaire de réinitialisation du mot de passe.
     */
    public function showResetPassword(User $user)
    {
        return view('admin.users.reset-password', compact('user'));
    }

    /**
     * Applique le nouveau mot de passe.
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', __('locale.password_reset_success', ['name' => $user->full_name]));
    }
}
