<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    // Hämtar alla plantor
    public function getPlants()
    {
        return Plant::all();
    }

    // Hämtar planta med specifikt id
    public function getPlantById($id)
    {
        // Lagrar planta i variabel
        $plant = Plant::find($id);

        // Om plantan existerar returneras den
        if ($plant != null) {
            return $plant;

        // Om plantan inte existerar skickas felmeddelande
        } else {
            return response()->json(['Plant not found'], 404);
        }
    }

    // Hämtar plantor för en specifik kategori
    public function getPlantsByCategory($id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin exixterar
        if ($category != null) {

            // Hämtar och returnerar alla plantor knutna till kategorin
            $plants = $category->plants;
            return response()->json(['plants' => $plants], 200);

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Lägger till planta knuten till en kategori
    public function addPlant(Request $request, $id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin existerar
        if ($category != null) {

            // Validerar
            $request->validate([
                'name' => 'required|string|max:64',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'price' => 'nullable|integer',
                'quantity' => 'required|integer'
            ]);

            // Skapar planta
            $plant = new Plant();
            $plant->name = $request->input('name');
            $plant->description = $request->input('description');
            $plant->price = $request->input('price');
            $plant->quantity = $request->input('quantity');

            // Om en bildfil har skickats med
            if ($request->hasFile('image')) {

                // Lagrar fil i en variabel
                $image = $request->file('image');

                // Genererar ett unikt filnamn
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Flyttar bild till katalog
                $image->move(public_path('uploads'), $imageName);

                // Sökväg till bild som ska lagras i databasen
                $plant->image = 'uploads/' . $imageName;
            }

            // Sparar plantan i databasen och bekräftar tillägg
            $category->plants()->save($plant);
            return response()->json(['Plant added'], 201);

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Uppdaterar planta med specifikt id


    // Raderar planta med specifikt id

}