<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito de compras.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Añade un producto al carrito.
     */
    public function add($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Debes iniciar sesión para agregar productos al carrito.');
        }

        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', '¡Producto agregado al carrito!');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $quantity = (int) $request->quantity;
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
                Session::put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Carrito actualizado correctamente.');
            }
        }
        // Si la cantidad es 0 o menos, lo eliminamos
        return $this->remove($id);
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vacía completamente el carrito de compras.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'El carrito se ha vaciado.');
    }
}