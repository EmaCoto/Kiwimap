<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    /**
     * Ver listado de doctores
     * - Requiere permiso "doctors.view"
     * - Si el usuario es "Doctor", permitimos el listado pero luego en el Index
     *   se limitará a ver SOLO su propio registro (no el de otros).
     */
    public function viewAny(User $user): bool
    {
        return $user->can('doctors.view');
    }

    /**
     * Ver un doctor en particular
     * - Con permiso "doctors.view"
     * - Si el usuario tiene rol "Doctor": solo puede verse a sí mismo.
     */
    public function view(User $user, Doctor $doctor): bool
    {
        if (! $user->can('doctors.view')) {
            return false;
        }

        if ($user->hasRole('Doctor')) {
            return $doctor->user_id === $user->id;
        }

        return true;
    }

    /**
     * Crear doctores
     */
    public function create(User $user): bool
    {
        return $user->can('doctors.create');
    }

    /**
     * Actualizar doctores
     * - Doctores NO pueden actualizar a otros doctores.
     * - Si quisieras permitir que un Doctor actualice SOLO su propia ficha:
     *   agrega || ($user->hasRole('Doctor') && $doctor->user_id === $user->id)
     */
    public function update(User $user, Doctor $doctor): bool
    {
        return $user->can('doctors.update');
    }

    /**
     * Eliminar doctores (solo Admin por configuración actual)
     */
    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->can('doctors.delete');
    }

    public function restore(User $user, Doctor $doctor): bool
    {
        return $user->can('doctors.delete');
    }

    public function forceDelete(User $user, Doctor $doctor): bool
    {
        return $user->can('doctors.delete');
    }
}
