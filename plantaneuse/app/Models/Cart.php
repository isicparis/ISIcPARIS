<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'plant_id',
        'price',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plante()
    {
        return $this->belongsTo(Plante::class, 'plant_id'); // Assurez-vous que 'plante_id' est la bonne clé étrangère
    }

}
