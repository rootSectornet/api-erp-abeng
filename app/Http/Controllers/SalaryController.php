<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $positionId = $request->query('position_id');

        if ($positionId) {
            $salarys = Salary::where('position_id', $positionId)->get();
        } else {
            $salarys = Salary::all();
        }

        return response()->json($salarys);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:16',
            'salary' => 'required|string|max:16',
            'position_id' => 'required|exists:positions,id',
            'is_active' => 'required|boolean',
        ]);

        $salary = Salary::create($validated);
        return response()->json($salary, 201);
    }

    public function show($id)
    {
        $salary = Salary::findOrFail($id);
        return response()->json($salary);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:16',
            'salary' => 'required|string|max:16',
            'position_id' => 'required|exists:positions,id',
            'is_active' => 'required|boolean',
        ]);

        $salary = Salary::findOrFail($id);
        $salary->update($validated);
        return response()->json($salary);
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();
        return response()->json(null, 204);
    }
}
