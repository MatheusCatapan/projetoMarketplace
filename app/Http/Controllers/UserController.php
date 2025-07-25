<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function atualizarUsuario(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|max:255,' . $user->id,
            'email' => 'sometimes|email|unique',
            'password' => 'sometimes|confirmed'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function mostrarUsuario(Request $request)
    {
        return $request->user();
    }

    public function deletarUsuario(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return response()->json(["Seu usuário foi deletado"]);
    }

    public function cadastrarUsuario(Request $request)
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

        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ], 201);
    }
}
