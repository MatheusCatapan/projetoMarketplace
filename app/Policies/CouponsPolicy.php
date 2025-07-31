<?php

namespace App\Policies;

use App\Models\User;

class CouponsPolicy
{

    public function deletar()
    {
        return auth()->user() && auth()->user()->isAdmin();
    }
}
