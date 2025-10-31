<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $CreatorRole = Role::firstOrCreate(['name' => 'Creater']);



        $editpermission = Permission::firstOrCreate(['name' => 'edit user']);
        $createpermission = Permission::firstOrCreate(['name' => 'create user']);


        $editorRole->givePermissionTo($editpermission);
        //$adminRole->givePermissionTo($permission);
        $CreatorRole->givePermissionTo($createpermission);

        $user = User::find(1);
        $user->assignRole(['admin']);


  }
}
