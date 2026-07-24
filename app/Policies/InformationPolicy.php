<?php

namespace App\Policies;

use App\Models\Information\Index;
use App\Models\User;

class InformationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('information.view');
    }

    public function view(User $user, Index $information): bool
    {
        return $user->can('information.view');
    }

    public function create(User $user): bool
    {
        return $user->can('information.create');
    }

    public function update(User $user, Index $information): bool
    {
        return $user->can('information.update');
    }

    public function delete(User $user, Index $information): bool
    {
        return $user->can('information.delete');
    }
}
