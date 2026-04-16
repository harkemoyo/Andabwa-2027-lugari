<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Blog management
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            
            // Category management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Navigation management
            'view navigation',
            'create navigation',
            'edit navigation',
            'delete navigation',
            
            // Media management
            'view media',
            'upload media',
            'delete media',
            
            // Activity management
            'view activities',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());
        
        $adminRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view roles', 'create roles', 'edit roles',
            'view posts', 'create posts', 'edit posts', 'delete posts', 'publish posts',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view navigation', 'create navigation', 'edit navigation', 'delete navigation',
            'view media', 'upload media', 'delete media',
            'view activities',
        ]);
        
        $editorRole->givePermissionTo([
            'view posts', 'create posts', 'edit posts', 'publish posts',
            'view categories',
            'view media', 'upload media',
        ]);
        
        $userRole->givePermissionTo([
            'view posts',
        ]);

        $this->command->info('✅ Roles and permissions seeded successfully!');
        $this->command->info('   Roles: Super Admin, Admin, Editor, User');
    }
}
