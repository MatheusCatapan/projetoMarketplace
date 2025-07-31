<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponsController;


//Login, logout
Route::post('/register', [AuthController::class, 'registrarUsuario']);
Route::post('/login', [AuthController::class, 'loginUsuario']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logoutUsuario']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rotas normais
// Route::apiResource('posts', PostController::class);
// Route::apiResource('categories', CategoryController::class);

//Rotas de endereços
Route::middleware('auth:sanctum')->get('/address', [AddressController::class, 'verEnderecos']);
Route::middleware('auth:sanctum')->post('/address', [AddressController::class, 'armazenarEndereco']);
Route::middleware('auth:sanctum')->put('/address/{address}', [AddressController::class, 'atualizarEndereco']);
Route::middleware('auth:sanctum')->delete('/address/{address}', [AddressController::class, 'deletarEndereco']);

//Rotas de categorias (admin)
Route::middleware(['auth:sanctum', 'admin'])->post('/categories', [CategoryController::class, 'cadastrarCategoria']);
Route::middleware(['auth:sanctum', 'admin'])->put('/categories/{category}', [CategoryController::class, 'atualizarCategoria']);
Route::middleware(['auth:sanctum', 'admin'])->delete('/categories/{category}', [CategoryController::class, 'deletarCategoria']);
Route::middleware('auth:sanctum')->get('/categories', [CategoryController::class, 'mostrarCategoria']);

//Rotas de carrinho
Route::middleware('auth:sanctum')->get('/carrinho', [CartController::class, 'criarCarrinhodeUsuario']);
Route::middleware('auth:sanctum')->post('/carrinho/adicionar', [CartController::class, 'adicionarProduto']);
Route::middleware('auth:sanctum')->delete('/carrinho/remover/{productId}', [CartController::class, 'removerProduto']);

//Rotas de admin
Route::middleware(['auth:sanctum', 'admin'])->put('/user/{id}', [UserController::class, 'atualizarUsuario']);
Route::middleware(['auth:sanctum', 'admin'])->delete('/user/{id}', [UserController::class, 'deletarUsuario']);
Route::middleware(['auth:sanctum', 'admin'])->post('/user', [UserController::class, 'cadastrarUsuario']);

//Rotas dos produtos - Moderadores
Route::middleware('auth:sanctum')->get('/product/{product}', [ProductController::class, 'mostrarProduto']);
Route::middleware(['auth:sanctum', 'moderador'])->post('/product', [ProductController::class, 'cadastrarProduto']);
Route::middleware(['auth:sanctum', 'moderador'])->put('/product/{product}', [ProductController::class, 'atualizarProduto']);
Route::middleware(['auth:sanctum', 'moderador'])->delete('/product/{product}', [ProductController::class, 'deletarProduto']);

//Rotas de cupons - Admin
Route::middleware(['auth:sanctum', 'admin'])->post('/coupons', [CouponsController::class, 'criarCupom']);
Route::middleware(['auth:sanctum', 'admin'])->get('/coupons', [CouponsController::class, 'listarCupons']);






