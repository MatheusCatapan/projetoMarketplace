<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


//Retorna todos os endereços do usuário autenticado
    public function verEnderecos(Request $request)
    {
        return $request->user()->addresses;
    }

    public function armazenarEndereco(Request $request)
    {
        $data = $request->validate([
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ]);
        $address = $request->user()->addresses()->create($data);
        return $address;
    }

    public function atualizarEndereco(Request $request, Address $address)
    {
        $this->authorize('update', $address);
        $address->update($request->only(['street', 'city', 'state', 'zip']));
        return $address;
    }

    public function deletarEndereco(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return response()->noContent();
    }
}
