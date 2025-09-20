<?php

namespace App\Policies;

use App\Models\State;
use App\Models\User;

class StatePolicy
{
    /** Listado */
    public function viewAny(User $user): bool
    {
        return $user->can('states.view');
    }

    /** Ver uno */
    public function view(User $user, State $state): bool
    {
        return $user->can('states.view');
    }

    /** Crear */
    public function create(User $user): bool
    {
        return $user->can('states.create');
    }

    /** Editar */
    public function update(User $user, State $state): bool
    {
        return $user->can('states.update');
    }

    /** Eliminar */
    public function delete(User $user, State $state): bool
    {
        return $user->can('states.delete');
    }

    /** Restaurar (si usas SoftDeletes) */
    public function restore(User $user, State $state): bool
    {
        return $user->can('states.delete');
    }

    /** Eliminar permanente */
    public function forceDelete(User $user, State $state): bool
    {
        return $user->can('states.delete');
    }
}
