<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', 'admin')->except(['listarCategorias', 'mostrarCategoria']);
    }
//Admins
    public function cadastrarCategoria(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255'
        ]);

        $category = Category::create($data);
        return response()->json($category, 201);
    }
//Admins
    public function deletarCategoria (Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

    public function listarCategorias()
    {
        return Category::all();
    }

    public function mostrarCategoria(Category $category)
    {
        return $category;
    }


}
