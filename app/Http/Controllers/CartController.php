<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;


class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function adicionarProduto(Request $request)
    {
        //Usuário deve estar logado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        //Atribuição de carrinho para o usuário
        else
        {
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        }

        //Ver se o produto está no carrinho
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->input('product_id'))
            ->first();

        //Se o produto já estiver no carrinho, atualiza a quantidade
        if ($item) {
            $item->quantity += $request->input('quantity');
            $item->save();
        }
        //Se o produto não estiver no carrinho, ele é adicionado
        else
        {
            $item = new CartItem();
            $item->cart_id = $cart->id;
            $item->product_id = $request->input('product_id');
            $item->quantity = $request->input('quantity');
            $item->save();
        }
        return response()->json(['message' => 'Produto adicionado ao carrinho com sucesso'], 200);
    }

    public function removerProduto(Request $request)
    {
        //Usuário deve estar logado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }
        //Atribuição de carrinho para o usuário
        else
        {
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        }
        //Consulta no banco de dados, basicamente é "busque o primeiro item no carrinho que tenha o product_id igual ao que foi passado"
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->input('product_id'))
            ->first();
        //Se o item existir, ele é removido
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Produto removido do carrinho com sucesso'], 200);
        }
        //Se o item não existir, retorna um erro
        else {
            return response()->json(['message' => 'Produto não encontrado no carrinho'], 404);
        }
    }

    public function mostrarCarrinho()
    {
        //Usuário deve estar logado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        //Atribuição de carrinho para o usuário
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        //Busca os itens do carrinho
        $items = CartItem::where('cart_id', $cart->id)->with('product')->get();

        //Retorna os itens do carrinho
        return response()->json($items, 200);
    }

    public function limparCarrinho()
    {
        //Usuário deve estar logado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        //Atribuição de carrinho para o usuário
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        //Remove todos os itens do carrinho
        CartItem::where('cart_id', $cart->id)->delete();

        return response()->json(['message' => 'Carrinho limpo com sucesso'], 200);
    }
}
