<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function index()
    {

        $messages = Message::all();

        return view('contact', ['messages' => $messages]);
    }
}
