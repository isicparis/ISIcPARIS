<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use Illuminate\Http\Request;

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
    public function create()
    {
        return view('plantes.create');
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
        //
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

        /*
        ///////////////////// a travailler
        

        // Path do the image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/plantes', 'public');
            $plante->image = $imagePath;
            $plante->save();
        }

        ////////////////////
        */
        return redirect()->route('plantes.edit', $id)
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
