<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        $citys = City::where('name', 'like', "%$searchTerm%")->get();

        return response()->json($citys);
    }
}

