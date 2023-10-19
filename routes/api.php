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
Route::middleware('auth:sanctum')->group(function () {

    // Routes för att registrera användare och logga ut
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('logout', 'logout');
    });

    // Routes för att hantera kategorier
    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'getCategories');
        Route::post('category', 'addCategory');
        Route::put('category/{id}', 'updateCategory');
        Route::delete('category/{id}', 'deleteCategory');
    });

    // Routes för att hantera produkter
    Route::controller(ProductController::class)->group(function () {
        Route::get('product', 'getProducts');
        Route::get('product/search/name/{name}', 'searchProduct');
        Route::post('product/{id}', 'addProduct');
        Route::put('product/{id}', 'updateProduct');
        Route::put('productquantity/{id}', 'updateQuantity');
        Route::delete('product/{id}', 'deleteProduct');
    });    
});

// Route för att logga in
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
