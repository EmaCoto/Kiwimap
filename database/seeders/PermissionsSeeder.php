<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        // Permisos CRUD de usuarios
        $perms = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'doctors.view','doctors.create','doctors.update','doctors.delete',
            'licenses.view','licenses.create','licenses.update','licenses.delete',
            'states.view','states.create','states.update','states.delete',
        ];

        foreach ($perms as $p) {
            Permission::findOrCreate($p, $guard);
        }

        // Asegura roles base con el guard correcto
        $roles = ['Admin','Front Desk','Doctor','Medical Assistant', 'Office Manager'];
        foreach ($roles as $r) {
            Role::findOrCreate($r, $guard);
        }

        $admin = Role::findByName('Admin', $guard);
        $admin->givePermissionTo(Permission::all());

        
        $front = Role::findByName('Office Manager', $guard);
        $front->givePermissionTo([
            'users.view'
        ]);

        
        $front = Role::findByName('Front Desk', $guard);
        $front->givePermissionTo([
            'users.view'
        ]);

        
        $front = Role::findByName('Doctor', $guard);
        $front->givePermissionTo([
            'users.view',
        ]);

       
        $front = Role::findByName('Medical Assistant', $guard);
        $front->givePermissionTo([
            'users.view',
        ]);

    }
}
