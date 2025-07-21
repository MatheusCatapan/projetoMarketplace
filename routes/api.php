<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;

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
Route::apiResource('products', ProductsController::class)->only(['index', 'show']);

//Rotas de admin
Route::middleware('auth:sanctum')->put('/user', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user', [UserController::class, 'delete']);


//Rotas dos produtos - Moderadores
Route::middleware('auth:sanctum', 'moderador')->post('/products', [ProductsController::class, 'store']);
Route::middleware('auth:sanctum', 'moderador')->put('/products/{product}', [ProductsController::class, 'update']);
Route::middleware('auth:sanctum', 'moderador')->delete('/products/{product}', [ProductsController::class, 'destroy']);







