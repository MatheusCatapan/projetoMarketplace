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
            'address_id' => 'required|exists:users_addresses,id',
            'coupon' => 'nullable|string'
        ]);

        // Calcula o total do carrinho
        $total = $user->cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $discount = 0;
        $couponId = null;

        // Aplica desconto se cupom válido
        if ($request->filled('coupon')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon)->first();
            if ($coupon && $coupon->is_active) {
                $discount = $coupon->discount; // supondo que seja valor fixo
                $couponId = $coupon->id;
            }
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $request->address_id;
        $order->order_date = now();
        $order->status = Order::STATUS_PENDING;
        $order->couponId = $couponId;
        $order->discount = $discount;
        $order->total_price = $total - $discount;
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

    public function cancelarPedido($id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['erro' => 'Usuário não autenticado'], 401);
        }

        $order = Order::find($id);

        if (!$order || $order->user_id !== $user->id) {
            return response()->json(['erro' => 'Pedido não encontrado ou não pertence ao usuário'], 404);
        }

        if ($order->status !== Order::STATUS_PENDING) {
            return response()->json(['erro' => 'Pedido não pode ser cancelado'], 400);
        }

        $order->status = Order::STATUS_CANCELLED;
        $order->save();

        return response()->json(['message' => 'Pedido cancelado com sucesso'], 200);
    }
    
    public function atualizarStatusPedido(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'MODERADOR') {
            return response()->json(['message' => 'Apenas moderadores podem atualizar o status do pedido'], 403);
        }

        $newStatus = $request->input('status');
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        if (!in_array($newStatus, ['PENDING', 'PROCESSING', 'SHIPPED', 'COMPLETED', 'CANCELLED'])) {
            return response()->json(['message' => 'Status inválido'], 400);
        }

        $order->status = $newStatus;
        $order->save();

        return response()->json(['message' => 'Status do pedido atualizado com sucesso'], 200);
    }
}
