<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $order = Order::where('user_id',$user_id)->get();
        return view('order',compact('order'));
    }
}
