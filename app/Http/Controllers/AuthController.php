<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrarUsuario(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return response()->json($user, 201);
    }

    public function loginUsuario(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email) ->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => "Dados inválidos!"
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];

    }

    public function logoutUsuario(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => "Você está deslogado!"
        ];
    }
}
