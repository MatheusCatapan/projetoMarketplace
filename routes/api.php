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

//Login, logout
Route::post('/register', [AuthController::class, 'registrarUsuario']);
Route::post('/login', [AuthController::class, 'loginUsuario']);
Route::post('/logout', [AuthController::class, 'logoutUsuario'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rotas normais
Route::apiResource('posts', PostController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('addresses', AddressController::class);
Route::apiResource('product', ProductController::class)->only(['index', 'show']);

//Rotas de carrinho
Route::middleware('auth:sanctum')->get('/carrinho', [CartController::class, 'criarCarrinhodeUsuario']);
Route::middleware('auth:sanctum')->post('/carrinho/adicionar', [CartController::class, 'adicionarProduto']);
Route::middleware('auth:sanctum')->delete('/carrinho/remover/{productId}', [CartController::class, 'removerProduto']);

//Rotas de admin
Route::middleware('auth:sanctum', 'admin')->put('/user/{id}', [UserController::class, 'atualizarUsuario']);
Route::middleware('auth:sanctum', 'admin')->delete('/user/{id}', [UserController::class, 'deletarUsuario']);
Route::middleware('auth:sanctum', 'admin')->post('/user', [UserController::class, 'cadastrarUsuario']);

//Rotas dos produtos - Moderadores
Route::middleware('auth:sanctum')->get('/product/{product}', [ProductController::class, 'mostrarProduto']);
Route::middleware('auth:sanctum', 'moderador')->post('/product', [ProductController::class, 'cadastrarProduto']);
Route::middleware('auth:sanctum', 'moderador')->put('/product/{product}', [ProductController::class, 'atualizarProduto']);
Route::middleware('auth:sanctum', 'moderador')->delete('/product/{product}', [ProductController::class, 'deletarProduto']);







