<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
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

    public function show(Request $request)
    {
        return $request->user();
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return response()->json(["Seu usuário foi deletado"]);
    }

}
