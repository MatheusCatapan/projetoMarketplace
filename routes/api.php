<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

//Login, logout
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rotas normais
Route::apiResource('posts', PostController::class);
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('addresses', AddressController::class);
Route::apiResource('product', ProductController::class)->only(['index', 'show']);

//Rotas de carrinho
Route::get('/cart', [CartController::class, 'show']);
Route::post('/cart', [CartController::class, 'add']);
Route::delete('/cart', [CartController::class, 'remove']);
Route::get('/cart/items', [CartController::class, 'list']);
Route::delete('/cart/clear', [CartController::class, 'clear']);

//Rotas de admin
Route::middleware('auth:sanctum')->put('/user', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user', [UserController::class, 'delete']);
Route::middleware('auth:sanctum')->post('/user', [UserController::class, 'store']);

//Rotas dos produtos - Moderadores
Route::middleware('auth:sanctum', 'moderador')->post('/product', [ProductController::class, 'store']);
Route::middleware('auth:sanctum', 'moderador')->put('/product/{product}', [ProductController::class, 'update']);
Route::middleware('auth:sanctum', 'moderador')->delete('/product/{product}', [ProductController::class, 'destroy']);







