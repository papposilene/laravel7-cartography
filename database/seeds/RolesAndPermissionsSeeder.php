<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'viewAny']);
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'restore']);
        Permission::create(['name' => 'destroy']);
        Permission::create(['name' => 'import']);
        Permission::create(['name' => 'export']);
        Permission::create(['name' => 'secret']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'guest'])
			->givePermissionTo([
                'viewAny',
                'view',
			]);
            
        $role = Role::create(['name' => 'editor'])
            ->givePermissionTo([
                'view',
                'create',
                'update',
                'delete',
                'restore',
			]);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'view',
                'create',
                'update',
                'delete',
                'restore',
                'import',
                'export',
			]);

        $role = Role::create(['name' => 'superAdmin'])
			->givePermissionTo(Permission::all());
    }
}