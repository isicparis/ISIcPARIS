<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plante extends Model
{
    use HasFactory;

    protected $table = 'plantes';

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = strtolower($searchTerm);

        return $query->where(DB::raw('LOWER(nom_commun)'), 'LIKE', $searchTerm . '%')
                     ->select('nom_commun')
                     ->distinct();
    }
}