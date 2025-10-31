<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::create(['name' => 'edit user']);
        $permission = Permission::create(['name' => 'create user']);
        $permission = Permission::create(['name' => 'delete user']);
        $permission = Permission::create(['name' => 'read user']);


    }
}
