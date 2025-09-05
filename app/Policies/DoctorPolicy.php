<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    /**
     * Ver listado de doctores
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Front Desk']);
    }

    /**
     * Ver un doctor en particular
     */
    public function view(User $user, Doctor $doctor): bool
    {
        // Admin y Front Desk ven todos
        if ($user->hasAnyRole(['Admin','Front Desk'])) {
            return true;
        }

        // Un doctor solo se ve a sí mismo
        return $user->hasRole('Doctor') && $doctor->user_id === $user->id;
    }

    /**
     * Crear doctores
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin','Front Desk']);
    }

    /**
     * Actualizar doctores
     */
    public function update(User $user, Doctor $doctor): bool
    {
        return $user->hasAnyRole(['Admin','Front Desk']);
    }

    /**
     * Eliminar doctores
     */
    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Restaurar (si usas SoftDeletes)
     */
    public function restore(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Eliminar permanentemente
     */
    public function forceDelete(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('Admin');
    }
}
