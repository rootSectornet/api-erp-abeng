<?php
namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'type' => 'required|in:BERAT,RINGAN',
            'is_active' => 'boolean'
        ]);

        $material = Material::create($validatedData);

        return response()->json($material, 201);
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        return response()->json($material);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric',
            'unit' => 'string|max:50',
            'type' => 'in:BERAT,RINGAN',
            'is_active' => 'boolean'
        ]);

        $material = Material::findOrFail($id);
        $material->update($validatedData);

        return response()->json($material);
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('name');

        $materials = Material::where('name', 'like', "%$searchTerm%")->get();

        return response()->json($materials);
    }
}

