<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the master role exists
        $masterRole = Role::firstOrCreate(['name' => 'master']);

        // Create or update abd12@gmail.com
        $user = User::updateOrCreate(
            ['email' => 'abd12@gmail.com'],
            [
                'name'     => 'Abdelrahman Elshareif',
                'password' => Hash::make('password'),
            ]
        );

        // Attach master role (sync prevents duplicates)
        $user->roles()->syncWithoutDetaching([$masterRole->id]);
    }
}
