<?php

namespace App\Http\Controllers;

use App\Models\ProductStep;
use Illuminate\Http\Request;

class ProductStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productId = $request->query('product_id');

        if ($productId) {
            $productSteps = ProductStep::where('product_id', $productId)
                                       ->orderBy('rank')
                                       ->get();
        } else {
            $productSteps = ProductStep::orderBy('rank')->get();
        }

        return response()->json($productSteps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'rank' => 'required|integer',
            'maxDuration' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ]);

        $productStep = ProductStep::create($validated);

        return response()->json($productStep, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productStep = ProductStep::findOrFail($id);
        return response()->json($productStep);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'rank' => 'required|integer',
            'maxDuration' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ]);

        $productStep = ProductStep::findOrFail($id);
        $productStep->update($validated);

        return response()->json($productStep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productStep = ProductStep::findOrFail($id);
        $productStep->delete();

        return response()->json(null, 204);
    }
}
