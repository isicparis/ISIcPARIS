<?php

namespace App\Http\Controllers;

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


}
