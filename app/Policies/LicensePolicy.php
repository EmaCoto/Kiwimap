<?php

namespace App\Policies;

use App\Models\License;
use App\Models\User;

class LicensePolicy
{
    /**
     * Ver listado de licencias
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Front Desk', 'Doctor']);
    }

    /**
     * Ver una licencia en particular
     */
    public function view(User $user, License $license): bool
    {
        // Admin y Front Desk ven todo
        if ($user->hasAnyRole(['Admin','Front Desk'])) {
            return true;
        }

        // Un doctor puede ver sus propias licencias
        return $user->hasRole('Doctor') && $license->doctor->user_id === $user->id;
    }

    /**
     * Crear licencias
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin','Front Desk']);
    }

    /**
     * Actualizar licencias
     */
    public function update(User $user, License $license): bool
    {
        return $user->hasAnyRole(['Admin','Front Desk']);
    }

    /**
     * Eliminar licencias
     */
    public function delete(User $user, License $license): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Restaurar (si usas SoftDeletes)
     */
    public function restore(User $user, License $license): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Eliminar permanentemente
     */
    public function forceDelete(User $user, License $license): bool
    {
        return $user->hasRole('Admin');
    }
}
