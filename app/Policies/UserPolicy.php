<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
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
