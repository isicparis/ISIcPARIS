<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Pour les requêtes directes
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $number_to_show = 3;

        // Récupérer les plantes depuis la base de données
        $plantes = DB::table('plantes')->limit($number_to_show)->get();

        // Retourner la vue avec les données
        return view('home', ['plantes' => $plantes]);
    }
}

