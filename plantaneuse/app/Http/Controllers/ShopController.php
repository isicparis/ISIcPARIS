<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plante;
class ShopController extends Controller
{
    public function index()
    {   
        $plantes=Plante::all();
        return view('shop',compact('plantes'));
    }
    
}
