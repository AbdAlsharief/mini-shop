<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /** List all admins and masters (not merchants/clients). */
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'master_admin'])->latest()->get();
        return view('master.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('master.admins.create');
    }

    /** Create an admin or another master_admin. */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'in:admin,master_admin'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        $label = $request->role === 'master_admin' ? 'Master Admin' : 'Admin';

        return redirect()->route('master.admins.index')
                         ->with('success', "{$label} '{$request->name}' created successfully.");
    }

    /** Demote an admin to client. Cannot demote another master_admin. */
    public function destroy(User $user)
    {
        if ($user->role === 'master_admin') {
            return redirect()->back()->with('error', 'Master admins cannot be demoted here.');
        }

        if (!in_array($user->role, ['admin', 'merchant'])) {
            return redirect()->back()->with('error', 'Invalid action.');
        }

        $user->update(['role' => 'client']);

        return redirect()->route('master.admins.index')
                         ->with('success', "'{$user->name}' has been demoted to client.");
    }
}
