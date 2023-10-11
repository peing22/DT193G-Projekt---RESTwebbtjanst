<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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

// Routes som kräver autentisering
Route::middleware(['auth:sanctum'])->group(function () {

    // Routes för att hantera kategorier
    Route::get('category', [CategoryController::class, 'getCategories']);
    Route::post('category', [CategoryController::class, 'addCategory']);
    Route::put('category/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('category/{id}', [CategoryController::class, 'deleteCategory']);

    // Routes för att hantera produkter
    Route::get('product', [ProductController::class, 'getProducts']);
    Route::get('product/search/name/{name}', [ProductController::class, 'searchProduct']);
    Route::post('product/{id}', [ProductController::class, 'addProduct']);
    Route::put('product/{id}', [ProductController::class, 'updateProduct']);
    Route::put('productquantity/{id}', [ProductController::class, 'updateQuantity']);
    Route::delete('product/{id}', [ProductController::class, 'deleteProduct']);

    // Route för att logga ut
    Route::post('logout', [AuthController::class, 'logout']);
});

// Publika routes för att registrera användare och logga in
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
