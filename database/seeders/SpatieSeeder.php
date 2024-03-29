<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class SpatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'show users', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit users', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'api']);
        Permission::create(['name' => 'change role', 'guard_name' => 'api']);

        Permission::create(['name' => 'store business', 'guard_name' => 'api']);

        Permission::create(['name' => 'edit business', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete business', 'guard_name' => 'api']);
        Permission::create(['name' => 'toggle business', 'guard_name' => 'api']);
        Permission::create(['name' => 'add teammate', 'guard_name' => 'api']);

        Permission::create(['name' => 'store products', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit products', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete products', 'guard_name' => 'api']);
        Permission::create(['name' => 'toggle products', 'guard_name' => 'api']);

        Permission::create(['name' => 'show invoices', 'guard_name' => 'api']);
        Permission::create(['name' => 'store invoices', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit invoices', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete invoices', 'guard_name' => 'api']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $customerRole = Role::create(['name' => 'customer', 'guard_name' => 'api']);
        $customerRole->givePermissionTo([
            'edit users',
            'show invoices',
            'store invoices',
            'edit invoices',
            'store business',
            ]);

        $ownerRole = Role::create(['name' => 'owner', 'guard_name' => 'api']);
        $ownerRole->givePermissionTo([
            'edit users',
            'add teammate',
            'store business',
            'edit business',
            'store products',
            'edit products',
            'toggle products',
            'show invoices',
        ]);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $adminRole->givePermissionTo([
            'show users',
            'edit users',
            'delete users',
            'change role',
            'delete business',
            'toggle business',
            'delete products',
            'toggle products',
            'show invoices',
            'edit invoices',
            'delete invoices',
        ]);

        // or may be done by chaining
//        $role = Role::create(['name' => 'moderator'])
//            ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::all());
    }
}
