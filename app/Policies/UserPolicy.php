<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->can('users.view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasRole('Admin') || $user->id === $model->id || $user->can('users.view');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->can('users.create');
    }

    public function update(User $user, User $model): bool
    {
        // Admin, o el mismo usuario (para editar sus datos básicos)
        return $user->hasRole('Admin') || $user->id === $model->id || $user->can('users.update');
    }

    public function delete(User $user, User $model): bool
    {
        // Nunca permitir que un usuario se elimine a sí mismo
        if ($user->id === $model->id) {
            return false;
        }
        return $user->hasRole('Admin') || $user->can('users.delete');
    }
}
