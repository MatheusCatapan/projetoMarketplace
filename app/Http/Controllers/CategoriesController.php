<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        return Category::all();
    }

    public function show(Categories $categories)
    {
        return $categories;
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required']);
        $categories = Categories::create($data);
        return $categories;
    }

    public function destroy (Category $categories)
    {
        $categories->delete();
        return response()->noContent();
    }
}
