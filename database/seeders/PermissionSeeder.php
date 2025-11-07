<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'user' => ['create', 'read', 'edit', 'delete'],
            'category' => ['create', 'read', 'edit', 'delete'],
            'package' => ['create', 'read', 'edit', 'delete'],
            'destination' => ['create', 'read', 'edit', 'delete'],
            'faq' => ['create', 'read', 'edit', 'delete'],
            'role' => ['create', 'read', 'edit', 'delete'],

     ];

        foreach ($modules as $module => $actions)
            array_map(fn($action) =>
                Permission::firstOrCreate(
                    ['name' => "{$action} {$module}"],
                    ['module_name' => $module]
                ),
            $actions);

        $this->command->info('✅ Permissions seeded successfully!');
    }
}
