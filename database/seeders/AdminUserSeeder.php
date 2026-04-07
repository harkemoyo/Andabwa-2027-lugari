<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);

        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Emoyo',
                'password' => Hash::make('password'), // easier for testing
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($role);

        $this->command->info('Admin user ready: admin@blog.com / 12345678');
    }
}
