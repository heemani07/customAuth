<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $editorRole  = Role::firstOrCreate(['name' => 'Editor']);
        $adminRole   = Role::firstOrCreate(['name' => 'Admin']);
        $creatorRole = Role::firstOrCreate(['name' => 'Creater']);

        // List of modules and actions
        $modules = [
            'user', 'category', 'package', 'destination', 'faq', 'role'
        ];

        $actions = ['create', 'read', 'edit', 'delete'];

        // Create permissions dynamically
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "$action $module"],
                    ['module_name' => $module]
                );
            }
        }

        // Get all permissions
        $allPermissions = Permission::all();

        // ⭐ Admin gets ALL permissions
        $adminRole->syncPermissions($allPermissions);

        // Optional: Editor & Creator specific permissions
        $editorRole->givePermissionTo('edit user');
        $creatorRole->givePermissionTo('create user');

        // Assign Admin role to user ID 1
        $user = User::find(1);
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
