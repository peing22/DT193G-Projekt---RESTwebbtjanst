<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hämtar alla kategorier sorterade efter namn
    public function getCategories()
    {
        return Category::orderBy('name')->get();
    }

    // Lägger till kategori
    public function addCategory(Request $request)
    {
        // Validerar
        $request->validate(['name' => 'required|string']);

        // Sparar kategori i databasen och bekräftar tillägg
        Category::create($request->all());
        return response()->json(['Category added'], 201);
    }

    // Raderar kategori
    public function deleteCategory($id) 
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin exixterar
        if($category != null) {

            // Raderar kategori och bekräftar raderingen
            $category->delete();
            return response()->json(['Category deleted']);

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }
}
