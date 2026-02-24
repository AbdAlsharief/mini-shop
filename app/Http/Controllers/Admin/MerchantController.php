<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = User::whereHas('roles', fn($q) => $q->where('name', 'merchant'))
                         ->with('roles', 'products')
                         ->latest()
                         ->get();

        return view('admin.merchants.index', compact('merchants'));
    }

    public function create()
    {
        return view('admin.merchants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'merchant')->firstOrFail();
        $user->roles()->attach($role->id);

        return redirect()->route('admin.merchants.index')
                         ->with('success', "Merchant '{$request->name}' created successfully.");
    }

    public function destroy(User $user)
    {
        if (!$user->roles->contains('name', 'merchant')) {
            return redirect()->back()->with('error', 'Only merchants can be removed here.');
        }

        $merchantRole = Role::where('name', 'merchant')->first();
        $user->roles()->detach($merchantRole->id);

        return redirect()->route('admin.merchants.index')
                         ->with('success', "'{$user->name}' has been demoted to customer.");
    }
}
