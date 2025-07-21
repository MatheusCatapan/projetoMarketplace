<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $product = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        return response()->json(['message' => 'Produto adicionado ao carrinho']);
    }

    public function remove(Request $request)
    {
        $product = $request->input('product_id');

        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        return response()->json(['message' => 'Produto removido do carrinho']);
    }

    public function list(Request $request)
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        return response()->json($cart->items);
    }

    public function clear(Request $request)
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        $cart->items()->delete();

        return response()->json(['message' => 'Carrinho limpo com sucesso']);
    }
}
