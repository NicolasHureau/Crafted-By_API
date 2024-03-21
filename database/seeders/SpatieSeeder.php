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
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'change role']);

        Permission::create(['name' => 'store business']);

        Permission::create(['name' => 'edit business']);
        Permission::create(['name' => 'delete business']);
        Permission::create(['name' => 'toggle business']);
        Permission::create(['name' => 'add teammate']);

        Permission::create(['name' => 'store products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'toggle products']);

        Permission::create(['name' => 'show invoices']);
        Permission::create(['name' => 'store invoices']);
        Permission::create(['name' => 'edit invoices']);
        Permission::create(['name' => 'delete invoices']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'edit users',
            'show invoices',
            'store invoices',
            'edit invoices',
            'store business',
            ]);

        $ownerRole = Role::create(['name' => 'owner']);
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

        $adminRole = Role::create(['name' => 'admin']);
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

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
