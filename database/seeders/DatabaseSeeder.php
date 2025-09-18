<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Doctor;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Roles (forzamos guard 'web' para evitar desajustes)
        foreach (['Admin','Front Desk','Doctor','Medical Assistant'] as $r) {
            Role::findOrCreate($r, 'web');
        }

        // 2) Usuario Admin inicial (verificado) + rol
        $admin = User::firstOrCreate(
            ['email' => 'desarrollokiwimed@gmail.com'],
            [
                'name' => 'Emanuel Cortés',
                'password' => Hash::make('123456789'), // seguro y válido
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Admin');

        // 3) (Opcional) Usuario Front Desk para pruebas
        $front = User::firstOrCreate(
            ['email' => 'frontdesk@kiwimap.com'],
            [
                'name' => 'Front Desk',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]
        );
        $front->assignRole('Front Desk');

        // 4) Semillas de catálogo y datos de negocio
        $this->call([
            PermissionsSeeder::class,
            StatesTableSeeder::class,
            DoctorsTableSeeder::class,
            LicensesTableSeeder::class,
        ]);

        // 5) Asegura rol 'Doctor' a los users creados por DoctorsTableSeeder
        Doctor::with('user')->get()->each(function ($d) {
            if ($d->user && !$d->user->hasRole('Doctor')) {
                $d->user->assignRole('Doctor');
                if (!$d->user->email_verified_at) {
                    $d->user->forceFill(['email_verified_at' => now()])->save();
                }
            }
        });
    }
}
