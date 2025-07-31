<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Coupon;


class CouponsController extends Controller
{
    //CRUD de Cupons de desconto são restritos a ADMIN
    //Descontos são associados a produtos
    //Cupons são aplicados a pedidos

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
    }

    public function criarCupom()
    {
        $cupom = request()->validate([
            'codigo' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric|min:0|max:100',
            'expires_at' => 'nullable|date'
        ]);

        $cupom = Coupon::create([
            'code' => $cupom['codigo'],
            'discount' => $cupom['discount'],
            'expires_at' => $cupom['expires_at'],
        ]);

        return response()->json([
            'message' => 'Cupom criado com sucesso',
            'cupom' => $cupom
        ], 201);
    }

    public function listarCupons()
    {
        $cupons = Coupon::all();

        return response()->json([
            'cupons' => $cupons
        ]);
    }

    public function deletarCupom($coupon_code)
{

        $cupom = Coupon::where('coupon_code', $coupon_code)->firstOrFail();
        $cupom->delete();

        return response()->json([
            'message' => 'Cupom deletado com sucesso'
    ], 200);
}
}
