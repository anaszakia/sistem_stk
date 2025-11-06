<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run role and permission seeder first
        $this->call(RolePermissionSeeder::class);

        // Create Super Admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        // Create Admin Transport user
        $adminTransport = User::create([
            'name' => 'Admin Transport',
            'email' => 'transport@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $adminTransport->assignRole('admin_transport');

        // Create Admin Departemen user
        $adminDepartemen = User::create([
            'name' => 'Admin Departemen',
            'email' => 'departemen@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $adminDepartemen->assignRole('admin_departemen');

        // Create Driver user
        $driver = User::create([
            'name' => 'Driver User',
            'email' => 'driver@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $driver->assignRole('driver');

        // Create Security user
        $security = User::create([
            'name' => 'Security User',
            'email' => 'security@gmail.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $security->assignRole('security');

        $this->command->info('========================================');
        $this->command->info('Sample Users Created Successfully:');
        $this->command->info('========================================');
        $this->command->newLine();
        
        $this->command->info('1. Super Admin');
        $this->command->info('   Email: superadmin@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('   Permissions: ' . $superAdmin->getAllPermissions()->count());
        $this->command->newLine();
        
        $this->command->info('2. Admin Transport');
        $this->command->info('   Email: transport@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('   Permissions: ' . $adminTransport->getAllPermissions()->count());
        $this->command->newLine();
        
        $this->command->info('3. Admin Departemen');
        $this->command->info('   Email: departemen@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('   Permissions: ' . $adminDepartemen->getAllPermissions()->count());
        $this->command->newLine();
        
        $this->command->info('4. Driver');
        $this->command->info('   Email: driver@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('   Permissions: ' . $driver->getAllPermissions()->count());
        $this->command->newLine();
        
        $this->command->info('5. Security');
        $this->command->info('   Email: security@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('   Permissions: ' . $security->getAllPermissions()->count());
        $this->command->newLine();
        
        $this->command->info('========================================');
    }
}
