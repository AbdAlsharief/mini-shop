<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /** List all admins and masters. */
    public function index()
    {
        $admins = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'master']))
                      ->with('roles')
                      ->latest()
                      ->get();

        return view('master.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('master.admins.create');
    }

    /** Create an admin or another master. */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'in:admin,master'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();
        $user->roles()->attach($role->id);

        $label = $request->role === 'master' ? 'Master Admin' : 'Admin';

        return redirect()->route('master.admins.index')
                         ->with('success', "{$label} '{$request->name}' created successfully.");
    }

    /** Demote an admin to customer. Cannot demote masters. */
    public function destroy(User $user)
    {
        $userRoles = $user->roles->pluck('name');

        if ($userRoles->contains('master')) {
            return redirect()->back()->with('error', 'Master admins cannot be demoted here.');
        }

        if (!$userRoles->contains('admin')) {
            return redirect()->back()->with('error', 'This user is not an admin.');
        }

        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->detach($adminRole->id);

        return redirect()->route('master.admins.index')
                         ->with('success', "'{$user->name}' has been demoted to customer.");
    }
}
