<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hämtar alla produkter sorterade efter namn
    public function getProducts()
    {
        return Product::orderBy('name')->get();
    }

    // Hämtar produkt med specifikt id
    public function getProductById($id)
    {
        // Lagrar produkt i variabel
        $product = Product::find($id);

        // Om produkten existerar returneras den
        if ($product != null) {
            return $product;

        // Om produkten inte existerar skickas felmeddelande
        } else {
            return response()->json(['Product not found'], 404);
        }
    }

    // Hämtar produkter för en specifik kategori
    public function getProductsByCategory($id)
    {
        // Lagrar kategori i variabel
        $category = Category::find($id);

        // Om kategorin exixterar
        if ($category != null) {

            // Hämtar och returnerar alla produkter knutna till kategorin, sorterade efter namn
            $products = $category->products()->orderBy('name')->get();
            return response()->json(['products' => $products], 200);

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Söker produkt efter namn
    public function searchProduct($name) 
    {
        // Returnerar produkt
        return Product::where('name', 'like', '%' . $name . '%')->get();
    }

    // Lägger till produkt knuten till en kategori
    public function addProduct(Request $request, $id)
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

            // Skapar produkt
            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->quantity = $request->input('quantity');

            // Om en bildfil har skickats med
            if ($request->hasFile('image')) {

                // Lagrar fil i en variabel
                $image = $request->file('image');

                // Genererar ett unikt filnamn
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Flyttar bild till katalog
                $image->move(public_path('uploads'), $imageName);

                // Sökväg till bild som ska lagras i databasen
                $product->image = 'uploads/' . $imageName;
            }

            // Sparar produktn i databasen och bekräftar tillägg
            $category->products()->save($product);
            return response()->json(['Product added'], 201);

        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Uppdaterar produkt med specifikt id
    public function updateProduct(Request $request, $categoryId, $productId)
    {
        // Lagrar kategori i variabel
        $category = Category::find($categoryId);
    
        // Om kategorin existerar
        if ($category != null) {

            // Lagrar produkten inom kategorin i en variabel
            $product = $category->products()->find($productId);
    
            // Om produktn existerar
            if ($product != null) {

                // Validerar
                $request->validate([
                    'name' => 'required|string|max:64',
                    'description' => 'nullable|string',
                    'image' => 'nullable|image|max:2048',
                    'price' => 'nullable|integer',
                    'quantity' => 'required|integer'
                ]);
    
                // Uppdaterar produktens egenskaper
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->price = $request->input('price');
                $product->quantity = $request->input('quantity');
    
                // Om en bildfil har skickats med
                if ($request->hasFile('image')) {
    
                    // Lagrar fil i en variabel
                    $image = $request->file('image');

                    // Genererar ett unikt filnamn
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                    // Flyttar bild till katalog
                    $image->move(public_path('uploads'), $imageName);

                    // Sökväg till bild som ska lagras i databasen
                    $product->image = 'uploads/' . $imageName;
                }
    
                // Sparar uppdaterad produkt i databasen och bekräftar uppdatering
                $product->save();
                return response()->json(['Product updated'], 200);

            // Om produkten inte existerar skickas felmeddelande
            } else {
                return response()->json(['Product not found'], 404);
            }
        // Om kategorin inte existerar skickas felmeddelande
        } else {
            return response()->json(['Category not found'], 404);
        }
    }

    // Uppdaterar kolumnen quantity
    public function updateQuantity(Request $request, $id) 
    {
        // Lagrar produkt i variabel
        $product = Product::find($id);

        // Om produkten existerar
        if ($product != null) {
            
            // Validerar
            $request->validate([
                'quantity' => 'required|integer'
            ]);

            // Uppdaterar antal
            $product->quantity = $request->input('quantity');

            // Sparar uppdaterad produkt i databasen och bekräftar uppdatering
            $product->save();
            return response()->json(['Product updated'], 200);

        // Om produkten inte existerar skickas felmeddelande
        } else {
            return response()->json(['Product not found'], 404);
        }
    }

    // Raderar produkt med specifikt id
    public function deleteProduct($id) 
    {
        // Lagrar produkt i variabel
        $product = Product::find($id);

        // Om produkten existerar
        if($product != null) {

            // Raderar produkt och bekräftar radering
            $product->delete();
            return response()->json(['Product deleted']);

        // Om produktn inte existerar skickas felmeddelande
        } else {
            return response()->json(['Product not found'], 404);
        }
    }
}
