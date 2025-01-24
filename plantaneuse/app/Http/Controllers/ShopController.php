<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Plante;
use Illuminate\Support\Facades\Http;


class ShopController extends Controller
{
    public function index()
    {
        $plantes = Plante::all();
        // Récupérer les valeurs uniques pour chaque champ de filtrage
        $filters = $this->getFilters();

        // Passez les plantes trouvées à la vue
        return view('shop', array_merge(compact('plantes'), $filters));
    }

    public function search(Request $request) {
        $response = Http::get('http://localhost:5000/search', [
            'word' => $request->input('search_word')
        ]);
        $query =$request->input('search_word');       
        $results= response()->json($response->json());
        $responseData = $response->json(); // Récupère la réponse JSON sous forme de tableau
        $ids = $responseData['results'] ?? [];
      
            // // Récupérer l'entrée utilisateur
            // $plantes=Plante::all();
            // $search = $request->input('search_word');
        
            // // Construire la commande pour exécuter le script Python
            // $scriptPath = '../../Indexation_requete/main.py';
            // $command = "python3 \"$scriptPath\" $search";
        
            // // Exécuter la commande
            // $output = shell_exec($command);
        
            // // Décoder le JSON renvoyé par le script Python
            // $results = json_decode($output, true);
        
            // // Vérifier si le résultat est valide
            // // if (isset($results['error'])) {
            // //     return response()->json(['error' => $results['error']], 400);
            // // }
        
            // if (isset($responseData['error'])) { // Vérifiez les données JSON directement
            //     $message = 'Aucun résultat trouvé.';
            //     return view('shop', compact('plantes', 'message'));
            // }
            // $plantes = Plante::whereIn('id', $results)->get();
            if (empty($ids)) {
                // Aucun résultat trouvé
                $erreur = 'Aucune plante trouvée pour le mot "' . $query . '".';
                return view('shop', compact('erreur'));
            }
        
            $plantes = Plante::whereIn('id', $ids)->get();

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
        $plantes = Plante::all();
        $filters = $this->getFilters();

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
            return view('shop', array_merge(compact('plantes', 'message'), $filters));
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

        $filters = $this->getFilters();

        return view('shop', array_merge(compact('plantes', 'message'), $filters));
    }

    public function exec_filter(Request $request)
    {
        // Récupérer les critères depuis la requête POST
        $criteres = $request->all(); // Récupère tous les critères envoyés via POST

        // Vérifier que des critères ont été envoyés
        if (empty($criteres)) {
            return response()->json([
                'message' => 'Aucun critère fourni.',
            ], 400);
        }

        // Récupérer toutes les plantes
        $plantes = Plante::all();

        // Créer une collection pour stocker le nombre de conditions remplies et l'ID
        $resultats = $plantes->map(function ($plante) use ($criteres) {
            $nbConditionRemplies = 0;

            // Parcourir les critères et vérifier les conditions
            foreach ($criteres as $attribut => $valeurs) {
                if (is_array($valeurs)) {
                    // Si l'attribut a plusieurs valeurs à vérifier
                    if (in_array($plante->$attribut, $valeurs)) {
                        $nbConditionRemplies++;
                    }
                } else {
                    // Si l'attribut a une seule valeur
                    if ($plante->$attribut == $valeurs) {
                        $nbConditionRemplies++;
                    }
                }
            }

            // Retourner un tableau contenant l'ID et le nombre de conditions remplies
            return [
                'id' => $plante->id,
                'nb_condition_remplies' => $nbConditionRemplies,
            ];
        });

        // Trier les résultats par le nombre de conditions remplies (ordre décroissant)
        $resultatsTries = $resultats
            ->filter(function ($resultat) {
                return $resultat['nb_condition_remplies'] > 0;
            })
            ->sortByDesc('nb_condition_remplies')
            ->values();
        $resultatIds = $resultatsTries->pluck('id')->toArray();



        // Construire une clause CASE pour ordonner les résultats
        $caseStatement = implode(' ', array_map(function ($id, $index) {
            return "WHEN id = $id THEN $index";
        }, $resultatIds, array_keys($resultatIds)));

        // Requête pour récupérer les plantes dans l'ordre trié
        $plantes = Plante::whereIn('id', $resultatIds)
            ->orderByRaw("CASE $caseStatement ELSE " . count($resultatIds) . " END")
            ->get();

        $filters = $this->getFilters();

        // Vérifiez si des plantes ont été trouvées
        if ($plantes->isEmpty()) {
            $message = 'Aucun résultat trouvé.';
            return view('shop', array_merge(compact('plantes', 'message'), $filters));
        }


        // Passez les plantes trouvées à la vue
        return view('shop', array_merge(compact('plantes'), $filters));
    }


    private function getFilters()
    {
        return [
            'prix_min' => Plante::min('prix_vente'),
            'prix_max' => Plante::max('prix_vente'),
            'prix_ventes' => Plante::distinct()->pluck('prix_vente'),
            'types_plantes' => Plante::distinct()->pluck('type_de_plante'),
            'niveaux_entretien' => Plante::distinct()->pluck('niveau_entretien'),
            'tailles' => Plante::distinct()->pluck('taille'),
            'besoins_lumiere' => Plante::distinct()->pluck('besoins_lumiere'),
            'couleurs' => Plante::distinct()->pluck('couleur'),
            'saisonnalites' => Plante::distinct()->pluck('saisonnalite'),
            'origines' => Plante::distinct()->pluck('origine'),
        ];
    }

    public function filter()
    {
        $plantes = Plante::all();
        // Récupérer les valeurs uniques pour chaque champ de filtrage
        $prix_min = Plante::min('prix_vente');
        $prix_max = Plante::max('prix_vente');
        $prix_ventes = Plante::distinct()->pluck('prix_vente');
        $types_plantes = Plante::distinct()->pluck('type_de_plante');
        $niveaux_entretien = Plante::distinct()->pluck('niveau_entretien');
        $tailles = Plante::distinct()->pluck('taille');
        $besoins_lumiere = Plante::distinct()->pluck('besoins_lumiere');
        $couleurs = Plante::distinct()->pluck('couleur');
        $saisonnalites = Plante::distinct()->pluck('saisonnalite');
        $origines = Plante::distinct()->pluck('origine');

        // ... et ainsi de suite pour tous les champs
        $plante = Plante::all();
        return view('filter', compact('plantes', 'prix_ventes', 'types_plantes', 'niveaux_entretien', 'besoins_lumiere', 'couleurs', 'tailles', 'saisonnalites', 'origines', 'prix_min', 'prix_max'));
    }
}
