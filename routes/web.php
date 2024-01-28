<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('shop');

Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('dodaj');
Route::get('/load-cart-data',[CartController::class, 'cartLoadByAjax']);
Route::get('/cart',[CartController::class, 'index'])->name('cart');
Route::post('/update-cart',[CartController::class, 'updateCart'])->name('update');
Route::post('/delete-cart',[CartController::class, 'deleteFromCart'])->name('delete');
Route::post('/clear-cart',[CartController::class, 'clearCart'])->name('clear');

Route::get('/zamówienie',[OrderController::class, 'index'])->name('order');
Route::post('/zamówienie',[OrderController::class, 'order']);
Route::get('/podsumowanie',[OrderController::class, 'summary'])->name('summary');

Auth::routes([
    'login' => false,
    'register' => false,
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
    'confirm' => false, // Password confirm']);
]);

Route::get('/loginPanel', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/loginPanel', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/showArticle/{id}', [ShopController::class, 'show'])->name('showArticle');

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/administracja', [HomeController::class, 'admin'])->name('admin');
    Route::put('/administracja/{id}', [HomeController::class, 'update'])->name('adminUpdate');
    Route::get('/artykuły', [ArticleController::class, 'index'])->name('articles');
    Route::get('/dodaj', [ArticleController::class, 'create'])->name('createArticle');
    Route::post('/dodaj', [ArticleController::class, 'store']);
    Route::get('/zmień/{id}', [ArticleController::class, 'edit'])->name('editArticle');
    Route::put('/zmień/{id}', [ArticleController::class, 'update']);
    Route::delete('/usuń/{id}', [ArticleController::class, 'destroy'])->name('deleteArticle');
    Route::middleware(['can:isAdministrator'])->group(function () {
        Route::get('/sadmin', [AdminController::class, 'index'])->name('sadmin');
    });
//    Route::get('/dodaj', [ArticleController::class, 'create'])->name('createArticle')->middleware('can:isOperator');
});


//Route::get('/home', [HomeController::class, 'index'])->name('home');
