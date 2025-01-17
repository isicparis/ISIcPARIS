<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plante extends Model
{
    protected $table = 'plantes';
    protected $primarykey = 'id_plante';

    public $incrimemnting= true;
    protected $keyType= 'int';

    protected $guarded = ['id_plante'];
}
