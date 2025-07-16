<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function __construct()
        {
            $this->middleware(['auth:sanctum', 'moderador'])->except(['index', 'show',]);
        }

    public function show(Products $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Products::create($data);
        return $product;
    }

    public function update(Request $request, Products $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|max:255',
            'description' => 'sometimes|max:255',
            'price' => 'sometimes|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return $product;
    }

    public function destroy (Products $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
