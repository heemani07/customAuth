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
        $deletepermission = Permission::firstOrCreate(['name' => 'delete user']);
        $readpermission = Permission::firstOrCreate(['name' => 'read user']);

        $editCatgorypermission = Permission::firstOrCreate(['name' => 'edit category']);
        $createCatgorypermission = Permission::firstOrCreate(['name' => 'create category']);
        $deleteCatgorypermission = Permission::firstOrCreate(['name' => 'delete category']);
        $readCatgorypermission = Permission::firstOrCreate(['name' => 'read category']);


        $editPackagepermission = Permission::firstOrCreate(['name' => 'edit package']);
        $createPackagepermission = Permission::firstOrCreate(['name' => 'create package']);
        $deletePackagepermission = Permission::firstOrCreate(['name' => 'delete package']);
        $readPackagepermission = Permission::firstOrCreate(['name' => 'read package']);

        $editDesinationpermission = Permission::firstOrCreate(['name' => 'edit destination']);
        $createDesinationpermission = Permission::firstOrCreate(['name' => 'create destination']);
        $deleteDesinationpermission = Permission::firstOrCreate(['name' => 'delete destination']);
        $readDesinationpermission = Permission::firstOrCreate(['name' => 'read destination']);

         $editFaqpermission = Permission::firstOrCreate(['name' => 'edit faq']);
        $createFaqpermission = Permission::firstOrCreate(['name' => 'create faq']);
        $deleteFaqpermission = Permission::firstOrCreate(['name' => 'delete faq']);
        $readFaqpermission = Permission::firstOrCreate(['name' => 'read faq']);

        $editrolepermission = Permission::firstOrCreate(['name' => 'edit role']);
        $createrolepermission = Permission::firstOrCreate(['name' => 'create role']);
        $deleterolepermission = Permission::firstOrCreate(['name' => 'delete role']);
        $readrolepermission = Permission::firstOrCreate(['name' => 'read role']);
        $editorRole->givePermissionTo($editpermission);
        //$adminRole->givePermissionTo($permission);
        $CreatorRole->givePermissionTo($createpermission);

        $user = User::find(1);
        $user->assignRole(['admin']);


  }
}
