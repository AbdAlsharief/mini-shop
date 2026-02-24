<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'abd12@gmail.com'],
            [
                'name'     => 'Abdelrahman Elshareif',
                'password' => Hash::make('password'), // only sets password if creating fresh
                'role'     => 'master_admin',
            ]
        );
    }
}
