<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_url' => 'nullable|url',
        ]);

// Crea el producto
    $product = Product::create($request->except('image_urls'));

    // Guarda las imágenes
    if ($request->has('image_urls')) {
        $urls = preg_split('/\\r\\n|\\r|\\n/', $request->image_urls);
        foreach ($urls as $index => $url) {
            if (!empty(trim($url))) {
                $product->images()->create(['image_url' => trim($url)]);
                // La primera imagen se guarda también como la principal en la tabla de productos
                if ($index == 0) {
                    $product->image_url = trim($url);
                    $product->save();
                }
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
}

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id,Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_url' => 'nullable|url',
        ]);

        // Actualiza el producto
    $product->update($request->except('image_urls'));

    // Borra las imágenes anteriores y guarda las nuevas
    $product->images()->delete();
    if ($request->has('image_urls')) {
        $urls = preg_split('/\\r\\n|\\r|\\n/', $request->image_urls);
        foreach ($urls as $index => $url) {
            if (!empty(trim($url))) {
                $product->images()->create(['image_url' => trim($url)]);
                if ($index == 0) {
                    $product->image_url = trim($url);
                    $product->save();
                }
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
}

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index');
    }
}
