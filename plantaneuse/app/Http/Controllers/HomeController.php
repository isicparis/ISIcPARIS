<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plante;

class HomeController extends Controller
{
    public function index()
    {
        $number_to_show = 3;

        $plantes = Plante::limit($number_to_show)->get();

    //     $os = PHP_OS_FAMILY;

    //     // Définit le chemin vers votre script Python
    //     $scriptPath = base_path('../../Indexation_requete/indexation_plantes.py');

    //     if ($os === 'Windows') {
    //         // Commande pour Windows
    //         // $command = 'python "' . "../../Indexation_requete/indexation_plantes.py" . '"';
    //         $command = 'start /B python "' . ".. /../Indexation_requete/indexation_plantes.py" . '" > ' . storage_path('logs/flask_output.log') . ' 2>&1';
    //         shell_exec($command);
    //         // pclose(popen("start /B " . $command .'" > ' . storage_path('logs/flask_output.log') . ' 2>&1', "r"));
    //     } else {
    //         // Commande pour Linux/Mac
    //         $command = 'python3 "' . $scriptPath . '" > /dev/null 2>&1 &';
    //         exec($command);
    //     }

        return view('home', ['plantes' => $plantes]);
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
        $plantes = Plante::all();
    

        // Vérifier si le produit existe déjà dans le panier
        // il faut avo
        $product_id = DB::table('plantes')->where('nom_commun', $product_name)->value('id');

        $exists = DB::table('cart')
            ->where('user_id', $user_id)
            ->where('plant_id', $product_id)
            ->exists();

        if ($exists) {
            DB::table('cart')
                ->where('user_id', $user_id)
                ->where('plant_id', $product_id)
                ->increment('quantity', $product_quantity);
            $message = 'Product added to cart';
            return view('home', compact('plantes', 'message'));
        }

        $price =  (float)substr($product_price, 1) * (int)$product_quantity;
        // Ajouter le produit au panier
        DB::table('cart')->insert([
            'user_id' => $user_id,
            'plant_id' => $product_id,
            'price' => $price,
            'quantity' => $product_quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $message = 'Product added to cart';



        return view('home', compact('plantes', 'message'));
    }
}
