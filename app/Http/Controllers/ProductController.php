<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
        {
            $this->middleware(['auth:sanctum', 'moderador'])->except(['index', 'show',]);
        }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'integer',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|max:255',
            'updated_at' => 'nullable|date',
            'created_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product', 'public');
        }

        $product = Product::create($data);
        return $product;
    }

    public function update(Request $request, Product $product)
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
        return $product;
    }

    public function destroy (Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
