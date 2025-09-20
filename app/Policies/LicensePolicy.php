<?php

namespace App\Policies;

use App\Models\License;
use App\Models\User;

class LicensePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('licenses.view');
    }

    public function view(User $user, License $license): bool
    {
        if (! $user->can('licenses.view')) {
            return false;
        }

        // Si es doctor: solo sus propias licencias
        if ($user->hasRole('Doctor')) {
            return $license->doctor->user_id === $user->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('licenses.create');
    }

    public function update(User $user, License $license): bool
    {
        if (! $user->can('licenses.update')) {
            return false;
        }

        // Si es doctor: solo puede actualizar sus propias licencias
        if ($user->hasRole('Doctor')) {
            return $license->doctor->user_id === $user->id;
        }

        return true;
    }

    public function delete(User $user, License $license): bool
    {
        return $user->can('licenses.delete');
    }

    public function restore(User $user, License $license): bool
    {
        return $user->can('licenses.delete');
    }

    public function forceDelete(User $user, License $license): bool
    {
        return $user->can('licenses.delete');
    }
}
