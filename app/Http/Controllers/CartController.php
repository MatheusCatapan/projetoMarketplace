<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function criarCarrinhodeUsuario()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        $cart = $user->cart()->firstOrCreate([]);

        return response()->json([
            'cart' => $cart->load('products')
        ]);
    }

    public function adicionarProduto(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        $cart = $user->cart()->firstOrCreate([]);

        $existing = $cart->products()->where('product_id', $request->product_id)->first();

        if ($existing) {
            $cart->products()->updateExistingPivot($request->product_id, [
                'quantity' => $existing->pivot->quantity + $request->quantity
            ]);
        } else {
            $cart->products()->attach($request->product_id, ['quantity' => $request->quantity]);
        }
        $sucesso = "Sucesso";
        return response()->json(['message' => 'Produto adicionado ao carrinho com sucesso'], 200);
    }

    public function removerProduto(Request $request, $productId)
    {

        $user = auth()->user();
        $cart = $user->cart();

        $cart = $user->cart()->first();
        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        $cart->products()->detach($productId);

        return response()->json(['message' => 'Produto removido do carrinho com sucesso'], 200);
    }
}
