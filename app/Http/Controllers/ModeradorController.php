<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ModeradorController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'in:CLIENT,MODERADOR,ADMIN'
        ]);

        if (!isset($fields['role'])) {
            $fields['role'] = 'CLIENT';
        }

        $fields['role'] = 'MODERADOR';
        $fields['password'] = Hash::make($fields['password']);

        $user = User::create($fields);
        return $user;
    }
}
