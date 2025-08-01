<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
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

//     public function removerProduto(Request $request, $productId)
//     {

//         $cart = $user->cart();

//         $cart = $user->cart()->first();
//         if (!$cart) {
//             return response()->json(['message' => 'Carrinho não encontrado'], 404);
//         }

//         $cart->products()->detach($productId);

//         return response()->json(['message' => 'Produto removido do carrinho com sucesso'], 200);
//     }
// }
}
