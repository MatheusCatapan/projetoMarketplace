<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin'])->except(['listarCategorias', 'mostrarCategoria']);
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
    public function atualizarCategoria(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255'
        ]);

        $category->update($data);
        return response()->json($category, 200);
    }

//Admins
    public function deletarCategoria (Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

//Mostrar categorias
    public function index()
    {
        return Category::all();
    }

    public function mostrarCategoria(Category $category)
    {
        return $category;
    }


}
