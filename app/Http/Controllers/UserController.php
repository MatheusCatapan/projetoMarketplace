<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['atualizarUsuario', 'mostrarUsuario', 'deletarUsuario']);
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

    public function atualizarUsuario(Request $request)
    {

        $this->authorize('atualizar', $request->user());

        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|max:255,' . $user->id,
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|confirmed'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            'user' => $user,
        ], 200);
    }

    public function mostrarUsuario(Request $request)
    {
        return $request->user();
    }

    public function deletarUsuario(Request $request)
    {

        $this->authorize('deletar', $request->user());

        $user = $request->user();
        $user->delete();

        return response()->json(["Seu usuário foi deletado"], 204);
    }
}
