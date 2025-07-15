<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|unique',
            'password' => 'sometimes|confirmed'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return "Seu usuário foi deletado";
    }

}
