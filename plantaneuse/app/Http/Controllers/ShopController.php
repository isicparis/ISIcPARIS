<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Plante;
class ShopController extends Controller
{
    public function index()
    {   
        $plantes=Plante::all();
        return view('shop',compact('plantes'));
    }

    public function search(Request $request) {
            // Récupérer l'entrée utilisateur
            $plantes=Plante::all();
            $search = $request->input('search_word');
        
            // Construire la commande pour exécuter le script Python
            $scriptPath = '..\\..\\Indexation_requete\\main.py';
            $command = "python \"$scriptPath\" $search";
        
            // Exécuter la commande
            $output = shell_exec($command);
        
            // Décoder le JSON renvoyé par le script Python
            $results = json_decode($output, true);
        
            // Vérifier si le résultat est valide
            // if (isset($results['error'])) {
            //     return response()->json(['error' => $results['error']], 400);
            // }
        
            if (isset($results['error'])) {
                $message = 'Aucun résultat trouvé.';
                return view('shop', compact('plantes', 'message'));
            } 
            $plantes = Plante::whereIn('id', $results)->get();

            // Vérifiez si des plantes ont été trouvées
            if ($plantes->isEmpty()) {
                $message = 'Aucun résultat trouvé.';
                return view('shop', compact('message'));
            }
        
            // Passez les plantes trouvées à la vue
            return view('shop', compact('plantes'));
    }


    public function addToCart(Request $request)
    {
        if (auth()->check()) {
            $user_id = auth()->id(); // Récupère l'ID de l'utilisateur connecté
        } else {
            return redirect()->route('login'); // Redirige vers la page de connexion
        }
        
    // Récupérer les données de la requête
    $user_id = auth()->id(); // Assurez-vous que l'utilisateur est authentifié
    //$user_id= '4';
    // la il faut faire la verification que le user est identifier sinon il sera renvoyer a la page de login 
    $product_name = $request->input('product_name');
    $product_price = $request->input('product_price');
    $product_image = $request->input('product_image');
    $product_quantity = $request->input('product_quantity');
    $plantes=Plante::all();

    // Vérifier si le produit existe déjà dans le panier
    // il faut avo
    $product_id= DB::table('plantes')->where('nom_commun',$product_name)->value('id');;
    $exists = DB::table('cart')
        ->where('user_id', $user_id)
        ->where('plant_id', $product_id)
        ->exists();

    if ($exists) {
        DB::table('cart')
        ->where('user_id', $user_id)
        ->where('plant_id', $product_id)
        ->increment('quantity',$product_quantity ); 
        $message='Product added to cart';
        return view('shop',compact('plantes','message'));
    }
    
    $price =  (float)substr($product_price, 1)* (int)$product_quantity;
    // Ajouter le produit au panier
    DB::table('cart')->insert([
        'user_id' => $user_id,
        'plant_id' => $product_id,
        'price' => $price,
        'quantity' => $product_quantity,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $message='Product added to cart';

    // return response()->json(['message' => 'Product added to cart'], 201); // Créé HTTP
    
    return view('shop',compact('plantes','message'));
    }



}
