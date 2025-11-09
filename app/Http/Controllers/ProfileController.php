<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
{
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
        ]);

        $user->update($validatedData);

        return redirect()->route('profile.index')->with('success', '¡Perfil actualizado exitosamente!');
    }
    public function orders()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $orders = $user->orders()->with('items.product')->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }
     public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el carrito de la sesión
        $cart = Session::get('cart', []);

        // Pasar los datos del usuario y el carrito a la vista
        return view('profile.index', compact('user', 'cart'));
    }
}
