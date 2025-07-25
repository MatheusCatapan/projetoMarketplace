<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
        {
            $this->middleware(['auth:sanctum', 'moderador'])->except(['mostrarProduto']);
        }

    public function mostrarProduto(Product $product)
    {
        return $product;
    }

    public function cadastrarProduto (Request $request)
    {
        $data = $request->validate([
            'id' => 'integer',
            'category_id' => 'required|integer',
            'name' => 'required|max:255',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product', 'public');
        }

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function atualizarProduto(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|max:255',
            'description' => 'sometimes|max:255',
            'price' => 'sometimes|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product', 'public');
        }

        $product->update($data);
        return response()->json($product, 200);
    }

    public function deletarProduto (Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
