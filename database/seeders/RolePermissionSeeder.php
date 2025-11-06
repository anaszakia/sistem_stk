<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create comprehensive permissions for full system management
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role & Permission Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'assign roles',
            'assign permissions',
            
            // Dashboard Access
            'access admin dashboard',
            'access user dashboard',
            
            // Profile Management
            'edit profile',
            'view profile',
            
            // Audit & Logs
            'view audit logs',
            'export audit logs',
            'delete audit logs',
            
            // Kendaraan Management
            'view kendaraan',
            'create kendaraan',
            'edit kendaraan',
            'delete kendaraan',
            
            // Pemesanan Kendaraan
            'view pemesanan',
            'create pemesanan',
            'edit pemesanan',
            'delete pemesanan',
            'approve pemesanan',
            'view all pemesanan',
            
            // System Settings
            'manage settings',
            'view reports',
            'export reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Super Admin role with ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create Admin Transport role
        $adminTransportRole = Role::firstOrCreate(['name' => 'admin_transport']);
        $adminTransportRole->givePermissionTo([
            'view kendaraan',
            'create kendaraan',
            'edit kendaraan',
            'delete kendaraan',
            'view users',
            'edit profile',
            'view profile',
            'access user dashboard',
            'view reports',
            'export reports',
            'view all pemesanan',
            'approve pemesanan',
        ]);

        // Create Admin Departemen role
        $adminDepartemenRole = Role::firstOrCreate(['name' => 'admin_departemen']);
        $adminDepartemenRole->givePermissionTo([
            'view kendaraan',
            'view users',
            'edit profile',
            'view profile',
            'access user dashboard',
            'view reports',
            'view pemesanan',
            'create pemesanan',
            'edit pemesanan',
            'delete pemesanan',
        ]);

        // Create Driver role
        $driverRole = Role::firstOrCreate(['name' => 'driver']);
        $driverRole->givePermissionTo([
            'view kendaraan',
            'edit profile',
            'view profile',
            'access user dashboard',
        ]);

        // Create Security role
        $securityRole = Role::firstOrCreate(['name' => 'security']);
        $securityRole->givePermissionTo([
            'view kendaraan',
            'edit profile',
            'view profile',
            'access user dashboard',
        ]);

        $this->command->info('All roles created successfully:');
        $this->command->info('- Super Admin (all permissions)');
        $this->command->info('- Admin Transport (manage kendaraan, view users, reports)');
        $this->command->info('- Admin Departemen (view kendaraan, users, reports)');
        $this->command->info('- Driver (view kendaraan only)');
        $this->command->info('- Security (view kendaraan only)');
        $this->command->info('Total permissions created: ' . count($permissions));
    }
}
