<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Supabase\Storage\StorageClient;

class PlanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $plantes = plante::all();

        return view('plantes.index', compact('plantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ajout()
    {
        return view('plantes.create');
    }

    public function create(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'nom_scientifique' => 'required|string|max:255',
            'nom_commun' => 'nullable|string|max:255',
            'famille' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'espece' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantite' => 'required|integer',
            'prix_achat' => 'required|numeric',
            'prix_vente' => 'required|numeric',
            'tags' => 'nullable|string',
            'type_de_plante' => 'nullable|string|max:255',
            'niveau_entretien' => 'nullable|string|max:255',
            'besoins_lumiere' => 'nullable|string|max:255',
            'frequence_arrosage' => 'nullable|string|max:255',
            'port_plante' => 'nullable|string|max:255',
            'floraison' => 'nullable|string|max:255',
            'toxicite' => 'nullable|boolean',
            'couleur' => 'nullable|string|max:255',
            'taille' => 'nullable|string|max:255',
            'saisonnalite' => 'nullable|string|max:255',
            'origine' => 'nullable|string|max:255',
        ]);

        // Create a new Plante instance
        $plante = new Plante();
        $plante->fill($request->except('image'));

        // Automatically increment ID (optional, if not using database auto-increment)
        $plante->id = Plante::max('id') + 1;

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Get Supabase credentials from environment variables
            $supabaseUrl = 'https://jzglofusihfqhmrmszho.supabase.co';
            $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imp6Z2xvZnVzaWhmcWhtcm1zemhvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mzc1NDYxNjcsImV4cCI6MjA1MzEyMjE2N30.Ft7Z6c1hCYBbX8XDTNuji1qwe0j1AN2ErL6T6FIuE5I'; // Utilisez une variable d'environnement pour la clé
            $bucketName = 'Images_plantes_backet_by_karim';

            // Prepare the file contents
            $fileContent = file_get_contents($file->getRealPath());
            // dd ($file->getRealPath());
            // Use Guzzle to send the request to Supabase
            $client = new Client();
            $imageUrl =  "$supabaseUrl/storage/v1/object/$bucketName/$fileName" ;
            $response = $client->request('POST', $imageUrl, [
                'headers' => [
                    'Authorization' => "Bearer $supabaseKey",
                    'Content-Type' => $file->getMimeType(),
                ],
                'body' => $fileContent,
            ]);

            $plante->image = "$supabaseUrl/storage/v1/object/public/$bucketName/$fileName" ;
        }

        // Save the plante to the database
        $plante->save();

        // Redirect with a success message
        return redirect()->route('plantes.index')->with('success', 'Plante ajoutée avec succès.');
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
    public function show(Plante $plante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $plante = Plante::where('id', $id)->get()[0];
        return view('plantes.edit', compact('plante'));
    }



    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom_scientifique' => 'required|string|max:255',
            'nom_commun' => 'nullable|string|max:255',
            'famille' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'espece' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => '',
            'quantite' => 'required|integer|min:0',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'tags' => 'nullable|string|max:255',
            'type_de_plante' => 'nullable|string|max:255',
            'niveau_entretien' => 'nullable|string|max:255',
            'besoins_lumiere' => 'nullable|string|max:255',
            'frequence_arrosage' => 'nullable|string|max:255',
            'port_plante' => 'nullable|string|max:255',
            'floraison' => 'nullable|string|max:255',
            'toxicite' => 'nullable|string|max:255',
            'couleur' => 'nullable|string|max:255',
            'taille' => 'nullable|string|max:255',
            'saisonnalite' => 'nullable|string|max:255',
            'origine' => 'nullable|string|max:255',
        ]);

        $plante = Plante::findOrFail($id);
        $plante->update($validated);

        
        ///////////////////// a travailler
        

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Get Supabase credentials from environment variables
            $supabaseUrl = 'https://jzglofusihfqhmrmszho.supabase.co';
            $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imp6Z2xvZnVzaWhmcWhtcm1zemhvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mzc1NDYxNjcsImV4cCI6MjA1MzEyMjE2N30.Ft7Z6c1hCYBbX8XDTNuji1qwe0j1AN2ErL6T6FIuE5I'; // Utilisez une variable d'environnement pour la clé
            $bucketName = 'Images_plantes_backet_by_karim';

            // Prepare the file contents
            $fileContent = file_get_contents($file->getRealPath());
            // dd ($file->getRealPath());
            // Use Guzzle to send the request to Supabase
            $client = new Client();
            $imageUrl =  "$supabaseUrl/storage/v1/object/$bucketName/$fileName" ;
            $response = $client->request('POST', $imageUrl, [
                'headers' => [
                    'Authorization' => "Bearer $supabaseKey",
                    'Content-Type' => $file->getMimeType(),
                ],
                'body' => $fileContent,
            ]);

            $plante->image = "$supabaseUrl/storage/v1/object/public/$bucketName/$fileName" ;
        }

        ////////////////////
        
        $plante->save();

        return redirect()->route('plantes.index')
            ->with('success', 'Plante mise à jour avec succès.');
    }

    public function delete ($id){
        $plante = Plante::findOrFail($id);
        $plante -> delete();
        return redirect()->route('plantes.index')
            ->with('success', 'Plante mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plante $plante)
    {
        //
    }
}
