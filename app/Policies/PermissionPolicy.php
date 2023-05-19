<?php

namespace App\Policies;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        //para ver todos los roles
    return $user->hasAnyRole(['super-admin',
                              'admin',
                              'secretaria',
                              'vendedor',
                              'proveedor',
                              'cliente']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin','admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasAnyRole(['super-admin','admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasAnyRole(['super-admin','admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $permission): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    //estas funciones es para realizar eliminaciones suaves
    public function forceDelete(User $user, Permission $permission): bool
    {
        //
    }
}
