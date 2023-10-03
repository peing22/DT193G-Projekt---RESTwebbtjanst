<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

Route::get('product', [ProductController::class, 'getProducts']);
Route::get('product/{id}', [ProductController::class, 'getProductById']);
Route::get('productsbycat/{id}', [ProductController::class, 'getProductsByCategory']);
Route::post('product/{id}', [ProductController::class, 'addProduct']);
Route::put('category/{categoryId}/product/{productId}', [ProductController::class, 'updateProduct']);
Route::delete('product/{id}', [ProductController::class, 'deleteProduct']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
