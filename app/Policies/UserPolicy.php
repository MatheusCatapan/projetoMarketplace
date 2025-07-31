<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function atualizar(User $authUser, User $user)
    {
        return $authUser->role === 'ADMIN' || $authUser->id === $user->id;
    }

    public function deletar(User $authUser, User $user)
    {
        return $authUser->role === 'ADMIN' || $authUser->id === $user->id;
    }
}
