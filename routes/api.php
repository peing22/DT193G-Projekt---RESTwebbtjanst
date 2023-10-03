<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('category', [CategoryController::class, 'getCategories']);
Route::post('category', [CategoryController::class, 'addCategory']);
Route::delete('category/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('plant', [PlantController::class, 'getPlants']);
Route::get('plant/{id}', [PlantController::class, 'getPlantById']);
Route::get('plantsbycat/{id}', [PlantController::class, 'getPlantsByCategory']);
Route::post('plant/{id}', [PlantController::class, 'addPlant']);
Route::put('category/{categoryId}/plant/{plantId}', [PlantController::class, 'updatePlant']);
Route::delete('plant/{id}', [PlantController::class, 'deletePlant']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
