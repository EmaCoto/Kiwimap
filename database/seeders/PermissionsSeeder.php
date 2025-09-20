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

        // 1) Definir todos los permisos del sistema (CRUDs básicos)
        $allPerms = [
            // Users
            'users.view', 'users.create', 'users.update', 'users.delete',
            // Doctors
            'doctors.view','doctors.create','doctors.update','doctors.delete',
            // Licenses
            'licenses.view','licenses.create','licenses.update','licenses.delete',
            // States
            'states.view','states.create','states.update','states.delete',
        ];

        foreach ($allPerms as $p) {
            Permission::findOrCreate($p, $guard);
        }

        // 2) Crear roles
        $roles = ['Admin','Office Manager','Front Desk','Doctor','Medical Assistant'];
        foreach ($roles as $r) {
            Role::findOrCreate($r, $guard);
        }

        // 3) Asignaciones exactas por rol (usamos syncPermissions)
        $admin = Role::findByName('Admin', $guard);
        $admin->syncPermissions($allPerms); // Admin = todo

        $office = Role::findByName('Office Manager', $guard);
        $office->syncPermissions([
            'users.view','users.create','users.update',
            'doctors.view','doctors.create','doctors.update',
            'licenses.view','licenses.create','licenses.update',
            'states.view','states.create','states.update',
        ]);

        $front = Role::findByName('Front Desk', $guard);
        $front->syncPermissions([
            'doctors.view',
            'licenses.view','licenses.create',
            'states.view','states.create',
        ]);

        $doctor = Role::findByName('Doctor', $guard);
        $doctor->syncPermissions([
            'doctors.view',
            'licenses.view','licenses.create','licenses.update',
            'states.view',
        ]);

        $ma = Role::findByName('Medical Assistant', $guard);
        $ma->syncPermissions([
            'doctors.view',
            'licenses.view',
            'states.view',
        ]);
    }
}
