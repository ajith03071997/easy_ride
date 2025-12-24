<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createRolesAndPermissions();
        $this->createDefaultAdminUser();
    }

    private function createRolesAndPermissions()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'web']);
        $driverRole = Role::firstOrCreate(['name' => 'driver', 'guard_name' => 'web']);

        $adminPermissions = [
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'manage_vendors',
            'manage_drivers',
            'manage_routes',
            'manage_trips',
            'manage_billing',
            'manage_notifications',
            'manage_support',
            'view_reports',
        ];

        $vendorPermissions = [
            'view_own_trips',
            'create_trip_request',
            'view_billing',
            'view_trip_cost',
            'raise_support_ticket',
        ];

        $driverPermissions = [
            'view_assigned_trips',
            'update_trip_status',
            'upload_documents',
            'view_earnings',
            'update_location',
        ];

        foreach (array_unique(array_merge($adminPermissions, $vendorPermissions, $driverPermissions)) as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        $adminRole->givePermissionTo($adminPermissions);
        $vendorRole->givePermissionTo($vendorPermissions);
        $driverRole->givePermissionTo($driverPermissions);
    }

    private function createDefaultAdminUser(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $admin = User::firstOrCreate(
            ['email' => 'pavithra@gmail.com'],
            [
                'name' => 'Pavithra',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'vendor_id' => null,
            ],
        );

        if ($adminRole && ! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
