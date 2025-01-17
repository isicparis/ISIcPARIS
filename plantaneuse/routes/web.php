<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PlanteController;





Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::view('/cart', 'cart')->name('cart');
// ...
 
//Route::resource('plantes', \App\Http\Controllers\PlanteController::class);
Route::get('/plantes/{id}/edit', [\App\Http\Controllers\PlanteController::class, 'edit'])->name('plantes.edit');
Route::get('/plantes', [\App\Http\Controllers\PlanteController::class, 'index'])->name('plantes.index');
//Route::put('/plante/{id}', [PlanteController::class, 'update'])->name('plante.update');
Route::put('/plantes/{id}', [PlanteController::class, 'update'])->name('plantes.update');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
