<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductStepController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CityController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('categories', CategoryController::class);
Route::apiResource('positions', PositionController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('materials', MaterialController::class);
Route::get('search/materials', [MaterialController::class, 'search']);
Route::get('search/city', [CityController::class, 'search']);
Route::resource('product-steps', ProductStepController::class);
Route::resource('salarys', SalaryController::class);
Route::post('projects', [ProjectController::class, 'create']);
Route::get('projects', [ProjectController::class, 'getListByStatus']);
Route::get('config/laba', [ProjectController::class, 'getLabaPerhari']);




