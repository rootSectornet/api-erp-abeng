<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Projects extends Controller
{
    /**
     * Create a Projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validations
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        return response()->json($validated);
    }
}
