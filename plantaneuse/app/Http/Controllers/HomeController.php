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

        return view('home', ['plantes' => $plantes]);
    }
}
