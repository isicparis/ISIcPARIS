<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CkeckoutController extends Controller
{
    
    public function index()
    {
        $user_id = auth()->id();
        $cart_items = Cart::where('user_id',$user_id)->get() ;
        return view('checkout', compact('cart_items'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'method' => 'required|string',
            'flat' => 'required|numeric',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pin_code' => 'required|numeric',
        ]);

        $user_id = Auth::id();
        $cart_items = Cart::where('user_id', $user_id)->get();
        $cart_total = $cart_items->sum(function ($item) {
            return $item->price ;
        });

        if ($cart_total == 0) {
            return redirect()->route('checkout.index')->with('error', 'Your cart is empty');
        }

        $user = User::findOrFail($user_id);
        $user->update([
            'phone' => $request->phone,
            'address' => 'flat no. ' . $request->flat . ', ' . $request->street . ', ' . $request->state . ', ' . $request->city . ', ' . $request->country . ' - ' . $request->pin_code,
        ]);
        $total_products = $cart_items->map(function ($item) {
            return $item->plante ? $item->plante->nom_commun : null; // Vérifier que la relation plante existe
        })->filter()->implode(', '); // Filtrer les valeurs null et joindre les noms avec une virgule
    
        $order = Order::create([
            'user_id' => $user_id,
            
            'payment_method' => $request->method,
            'total_products' => $total_products,
            'total_price' => $cart_total,
            'placed_on' => now()->format('d-M-Y'),
        ]);


        Cart::where('user_id', $user_id)->delete();

        return redirect()->route('checkout.index')->with('success', 'Order placed successfully');
    }



}
