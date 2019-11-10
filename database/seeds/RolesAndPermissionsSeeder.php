<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'scrape year']);
        Permission::create(['name' => 'scrape issue']);
        Permission::create(['name' => 'create issue']);
        Permission::create(['name' => 'create stamp']);
        Permission::create(['name' => 'update issue']);
        Permission::create(['name' => 'update stamp']);

        Role::create(['name' => 'admin'])
                ->givePermissionTo([
                    'scrape year',
                    'scrape issue',
                    'create stamp',
                    'create issue',
                    'update stamp',
                    'update issue',
                ]);
    }
}
