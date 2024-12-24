<?php

use App\Http\Controllers\ProductController;


Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/', [ProductController::class, 'index'])->name('home');