<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController
{
    public function __construct()
    {
        $this->middlware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        return Category::all();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required']);
        $category->update($data);
        return $category;
    }

    public function destroy (Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
