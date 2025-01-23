<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Plante extends Model
{
    protected $table = 'plantes';
    protected $primarykey = 'id_plante';

    public $incrimemnting= true;
    protected $keyType= 'int';

    protected $guarded = ['id_plante'];
    public function scopeSearch($query, $searchTerm)
{
    $searchTerm = strtolower($searchTerm);
    return $query->where(DB::raw('LOWER(nom_commun)'), 'LIKE', $searchTerm . '%')
                 ->select('id', 'nom_commun', 'prix_achat', 'image'); 
}
}
