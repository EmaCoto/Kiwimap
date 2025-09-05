<?php

namespace App\Policies;

use App\Models\State;
use App\Models\User;

class StatePolicy
{
    /**
     * Ver listado de estados
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Front Desk', 'Doctor', 'Medical Assistant']);
    }

    /**
     * Ver un estado en particular
     */
    public function view(User $user, State $state): bool
    {
        return $user->hasAnyRole(['Admin', 'Front Desk', 'Doctor', 'Medical Assistant']);
    }

    /**
     * Crear estados
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Actualizar estados
     */
    public function update(User $user, State $state): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Eliminar estados
     */
    public function delete(User $user, State $state): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Restaurar (si usas SoftDeletes)
     */
    public function restore(User $user, State $state): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Eliminar permanentemente
     */
    public function forceDelete(User $user, State $state): bool
    {
        return $user->hasRole('Admin');
    }
}
