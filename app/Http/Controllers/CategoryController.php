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

    // Hämtar kategori med specifikt id
    public function getCategoryById($id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin existerar returneras den
        if ($category != null) {
            return $category;

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
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

    // Uppdaterar kategori
    public function updateCategory(Request $request, $id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin existerar
        if ($category != null) {

            // Validerar
            $request->validate(['name' => 'required|string']);

            // Uppdaterar kategori i databasen och bekräftar uppdatering
            $category->update($request->all());
            return response()->json(['Category updated'], 200);
        
        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Raderar kategori
    public function deleteCategory($id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin exixterar
        if ($category != null) {

            // Raderar kategori och bekräftar radering
            $category->delete();
            return response()->json(['Category deleted']);

            // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }
}
