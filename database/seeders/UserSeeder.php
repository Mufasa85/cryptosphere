<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrateur',
                'email' => 'admin@exemple.com',
                'phone' => '+243900000001',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Agent de crédit',
                'email' => 'agent@exemple.com',
                'phone' => '+243900000002',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'is_active' => true,
            ],
            [
                'name' => 'Client',
                'email' => 'client@exemple.com',
                'phone' => '+243900000003',
                'password' => Hash::make('password'),
                'role' => 'client',
                'is_active' => true,
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );

            if (! $user->hasRole($user->role)) {
                $user->assignRole($user->role);
            }
        }
    }
}
