<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function store (Request $request)
    {

    $fields = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'role' => 'in:CLIENT, MODERADOR, ADMIN'
    ]);

    if (!isset($fields['role'])) {
        $fields['role'] = 'CLIENT';
    };

    $user = User::create($user);
    return $user;

}
}
