<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class SaleController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('sales.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:3048' // Cada imagen debe ser válida
        ]);

        // Guardar la venta
        $sale = Sale::create([
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'issold' => false,
            'image' => null, // Se actualizará con la primera imagen
        ]);

        // Manejar la subida de imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('images', 'public'); // Guardar en storage/app/public/images

                // Guardar en la tabla de imágenes
                $sale->images()->create([
                    'route' => $imagePath
                ]);

                // Si es la primera imagen, establecerla como miniatura
                if ($index === 0) {
                    $sale->update(['image' => $imagePath]);
                }
            }
        }

        return redirect()->route('home')->with('success', 'Producto publicado correctamente.');
    }


    public function mySales()
    {
        $sales = Sale::where('user_id', Auth::id())->get(); // Obtener solo los productos del usuario autenticado
        return view('sales.mySales', compact('sales'));
    }
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function buy(Sale $sale)
    {
        if (Auth::id() === $sale->user_id) {
            return redirect()->back()->with('error', 'No puedes comprar tu propio producto.');
        }

        if ($sale->issold) {
            return redirect()->back()->with('error', 'Este producto ya ha sido vendido.');
        }

        $sale->issold = true;
        $sale->save();

        return redirect()->route('sales.show', $sale->id)->with('success', 'Has comprado este producto.');
    }

    public function edit(Sale $sale)
    {
        if (Auth::id() !== $sale->user_id) {
            return redirect()->route('home')->with('error', 'No tienes permiso para editar este producto.');
        }

        $categories = Category::all();
        return view('sales.edit', compact('sale', 'categories'));
    }


    public function update(Request $request, Sale $sale)
    {
        if (Auth::id() !== $sale->user_id) {
            return redirect()->route('home')->with('error', 'No tienes permiso para editar este producto.');
        }

        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $sale->update([
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sales', 'public');
            $sale->image = $path;
            $sale->save();
        }

        return redirect()->route('home')->with('success', 'Producto actualizado con éxito.');
    }

    public function relist(Sale $sale)
    {
        if (Auth::id() !== $sale->user_id) {
            return redirect()->route('home')->with('error', 'No tienes permiso para reponer este producto en venta.');
        }

        $sale->issold = false;
        $sale->save();

        return redirect()->route('sales.show', $sale->id)->with('success', 'Producto repuesto en venta con éxito.');
    }

    public function destroy(Sale $sale)
    {
        if (Auth::id() !== $sale->user_id) {
            return redirect()->route('home')->with('error', 'No tienes permiso para eliminar este producto.');
        }

        $sale->delete();

        return redirect()->route('home')->with('success', 'Producto eliminado con éxito.');
    }
}
