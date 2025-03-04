<?php

namespace App\Policies\User;

use App\Models\User;
use App\Models\User\Role;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\Authorizable;

class UserPolicy
{
    use Authorizable;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([Role::ADMIN, Role::MODERATOR]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole([Role::ADMIN])) {
            return true;
        }

        if ($user->hasRole([Role::MODERATOR]) ) {
            return !$model->hasRole([Role::ADMIN]);
        }

        if ($user->hasRole([Role::CLIENT])) {
            return !$model->hasRole([Role::MODERATOR, Role::ADMIN])
                && $user->getKey() === $model->getKey();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole([Role::ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasRole([Role::ADMIN])) {
            return true;
        }

        if ($user->hasRole([Role::MODERATOR])) {
            return !$model->hasRole([Role::ADMIN]);
        }

        if ($user->hasRole([Role::CLIENT])) {
            return $user->getKey() === $model->getKey();
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->hasRole([Role::MODERATOR])) {
            return false;
        }

        if ($user->hasRole([Role::CLIENT])) {
            return $user->getKey() === $model->getKey();
        }

        return $user->hasRole([Role::ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole([Role::ADMIN]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole([Role::ADMIN]);
    }
}
