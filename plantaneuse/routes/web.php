<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CkeckoutController;
use App\Http\Controllers\PlanteController;

// ...
 
Route::post('/shop/autocomplete', [ShopController::class, 'autocomplete'])->name('shop.autocomplete');
Route::get('/shop/autoload', [ShopController::class, 'autoload'])->name('shop.autoload');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'addToCart'])->name('home.addToCart');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::post('/shop', [ShopController::class, 'addToCart'])->name('shop.addToCart');

Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::get('/shop/filter', [ShopController::class, 'filter'])->name('shop.filter');
Route::view('/filter', 'filter')->name('filter');
Route::post('/exec-filter', [ShopController::class, 'exec_filter'])->name('filter.exec');


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CkeckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CkeckoutController::class, 'store'])->name('checkout.store');
});

// Route::resource('cart', \App\Http\Controllers\CartController::class);
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::delete('/cart', [CartController::class, 'destroyAll'])->name('cart.delete_all');

});
//Route::resource('plantes', \App\Http\Controllers\PlanteController::class);

Route::post('/plantes/create', [\App\Http\Controllers\PlanteController::class, 'create'])->name('plantes.create');
// Route::put('/plantes/create', [\App\Http\Controllers\PlanteController::class, 'create'])->name('plantes.create');
Route::get('/plantes/ajouter', [\App\Http\Controllers\PlanteController::class, 'ajout'])->name('plantes.ajout');
Route::get('/plantes/{id}/edit', [\App\Http\Controllers\PlanteController::class, 'edit'])->name('plantes.edit');
Route::get('/plantes/{id}/delete', [\App\Http\Controllers\PlanteController::class, 'delete'])->name('plantes.delete');
Route::get('/plantes', [\App\Http\Controllers\PlanteController::class, 'index'])->name('plantes.index')->middleware('is_admin');

Route::put('/plante/{id}', [PlanteController::class, 'update'])->name('plante.update');
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
