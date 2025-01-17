<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'payment_method',
        'total_products',
        'total_price',
        'placed_on',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
