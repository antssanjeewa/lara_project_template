<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'view adminboard']);
        Permission::create(['name' => 'view billinventory']);
        Permission::create(['name' => 'view management']);
        Permission::create(['name' => 'view report']);

        Permission::create(['name' => 'add']);
        Permission::create(['name' => 'add cash']);
        Permission::create(['name' => 'add staff']);
        Permission::create(['name' => 'add members']);
        Permission::create(['name' => 'add adminboard']);
        Permission::create(['name' => 'add billinventory']);
        Permission::create(['name' => 'add management']);

        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'edit cash']);
        Permission::create(['name' => 'edit staff']);
        Permission::create(['name' => 'edit members']);
        Permission::create(['name' => 'edit adminboard']);
        Permission::create(['name' => 'edit billinventory']);
        Permission::create(['name' => 'edit management']);

        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'delete cash']);
        Permission::create(['name' => 'delete staff']);
        Permission::create(['name' => 'delete members']);
        Permission::create(['name' => 'delete adminboard']);
        Permission::create(['name' => 'delete billinventory']);
        Permission::create(['name' => 'delete management']);

        Permission::create(['name' => 'notification']);
        Permission::create(['name' => 'cancel bill']);
        Permission::create(['name' => 'navigation controll']);
        Permission::create(['name' => 'department controll']);


        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'advisor']);
        $role->givePermissionTo([
            'view',
            'view dashboard',
            'view adminboard',
            'view billinventory',
            'view management',
            'view report'
        ]);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // or may be done by chaining
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::where('name','not like','delete%')->get() );
            $role->revokePermissionTo("add management");
            $role->revokePermissionTo("edit management");
            $role->revokePermissionTo("notification");
            $role->revokePermissionTo("cancel bill");
            $role->revokePermissionTo("navigation controll");
            $role->revokePermissionTo("department controll");
           

        // or may be done by chaining
        $role = Role::create(['name' => 'manager'])
            ->givePermissionTo(Permission::where('name','like','%add%')->get() )
            ->givePermissionTo([
                'view',
                'view billinventory',
                'view report'
            ]);

        // or may be done by chaining
        $role = Role::create(['name' => 'accountant'])
            ->givePermissionTo([
                'view',
                'view billinventory',
                'view report'
            ]);

        // or may be done by chaining
        $role = Role::create(['name' => 'call-center'])
            ->givePermissionTo([
                'view',
                'view report',
                'add members'
            ]);

        // or may be done by chaining
        $role = Role::create(['name' => 'member'])
            ->givePermissionTo([
                'view'
            ]);

        $user = User::find(1);
        if($user)
            $user->assignRole('super-admin');
    }
}
