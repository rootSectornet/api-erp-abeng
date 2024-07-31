<?php
namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        return Position::join('salarys', 'salarys.position_id', '=', 'positions.id')
                    ->select('positions.id', 'positions.name', 'positions.is_active', 'salarys.type', 'salarys.salary')
                    ->orderBy('salarys.salary')
                    ->get();

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $position = Position::create($validatedData);

        return response()->json($position, 201);
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);
        return response()->json($position);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'is_active' => 'boolean'
        ]);

        $position = Position::findOrFail($id);
        $position->update($validatedData);

        return response()->json($position);
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return response()->json(null, 204);
    }
}
