<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plante extends Model
{
    //
    protected $table = 'plantes';

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

}
