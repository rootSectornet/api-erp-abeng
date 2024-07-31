<?php
namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryProduct::withCount('products')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $category = CategoryProduct::create($validatedData);

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = CategoryProduct::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'is_active' => 'boolean'
        ]);

        $category = CategoryProduct::findOrFail($id);
        $category->update($validatedData);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = CategoryProduct::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}

