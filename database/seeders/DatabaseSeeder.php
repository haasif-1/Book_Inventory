<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          $adminRole = Role::firstOrCreate(['name' => 'admin']);
          $clerkRole = Role::firstOrCreate(['name' => 'clerk']);
        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // check if admin exists
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Change this to something secure
            ]
        );
        $clerk = User::firstOrCreate(
            ['email' => 'clerk@gmail.com'], // check if clerk exists
            [
                'name' => 'Clerk User',
                'password' => Hash::make('password'), // Change this to something secure
            ]
        );

        // Assign role to admin
                if (!$admin->hasRole('admin')) {
                    $admin->assignRole($adminRole);
                }
                if (!$clerk->hasRole('clerk')) {
                    $clerk->assignRole($clerkRole);
                }
    }
}
