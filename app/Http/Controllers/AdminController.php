<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
    }

    public function criarAdmin(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'in:CLIENT,MODERADOR,ADMIN'
        ]);

        $fields['role'] = 'ADMIN';
        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);
        return response()->json($user, 201);
    }

    public function listarAdmins()
    {
        return User::where('role', 'ADMIN')->get();
    }
};

