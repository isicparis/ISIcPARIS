<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Plante;


use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if (auth()->check()) {
            $user_id = auth()->id(); // Récupère l'ID de l'utilisateur connecté
        } else {
            return redirect()->route('login'); // Redirige vers la page de connexion
        }
       
        $cart = Cart::where('user_id', $user_id)->get();

        $plantes = Plante::whereIn('id', $cart->pluck('plant_id'))->get();
        return view('cart',compact('cart','plantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        // dd($request->price, $request->quantity, $cart->price);
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
        ]);

    $cart->quantity = $request->quantity;
    
    $cart->price = $validated['price'] * $validated['quantity'];
    
    $cart->save();
   

    return redirect()->route('cart.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Vérifier que le cart existe
        if ($cart) {
            $cart->delete();
            return redirect()->route('cart.index')->with('success', 'Item deleted successfully.');
        } else {
            return  'Item not found' ;
        }
    }
    
    public function destroyAll()
{
    Cart::where('user_id', auth()->id())->delete();
    return redirect()->route('cart.index');
}
}
