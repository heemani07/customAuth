<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        UserSeeder::class,
        RoleSeeder::class,
        PermissionSeeder::class,
        RolePermissionSeeder::class// Call your new seeder here
    ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
