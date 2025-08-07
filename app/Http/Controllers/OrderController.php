<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function criarPedido(Request $request)
    {
        //User deve estar autenticado
        $user = auth()->user();

        if(!$user) {
            return response()->json(['erro' => 'Usuário não autenticado'], 401);
        }

        //Verifica se o usuário tem um carrinho (com itens)
        if (!$user->cart || $user->cart->items->isEmpty()) {
            return response()->json(['message' => 'Carrinho vazio'], 400);
        }
        //Valida o endereço
        $request->validate([
            'address_id' => 'required|exists:users_addresses,id'
        ]);

        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $request->address_id;
        $order->order_date = now();
        $order->status = Order::STATUS_PENDING;
        //Calcula o preço total do pedido com base nos itens do carrinho
        $order->total_price = $user->cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $order->save();

        //Transfere os itens do carrinho para o pedido
        foreach ($user->cart->items as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product->price;
            $orderItem->save();
        }

        //Limpa o carrinho após a criação do pedido
        $user->cart->items()->delete();
        return response()->json(['message' => 'Pedido criado com sucesso', 'order_id' => $order->id], 201);
    }

}
