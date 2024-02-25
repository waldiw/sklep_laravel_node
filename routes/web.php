<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StatuteController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/regulamin-sklepu', [ShopController::class, 'statute'])->name('showStatute');

Route::get('/cart',[CartController::class, 'index'])->name('cart');
Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('dodaj');
Route::get('/load-cart-data',[CartController::class, 'cartLoadByAjax']);

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
    Route::get('/home', [OperatorController::class, 'index'])->name('home');
    Route::get('/zamówienie-szczegóły/{id}', [OperatorController::class, 'editOrder'])->name('editOrder');
    Route::put('/zamówienie-szczegóły/{id}', [OperatorController::class, 'updateOrder']);
    Route::delete('/zamówienie-szczegóły/{id}', [OperatorController::class, 'deleteOrder'])->name('deleteOrder');

    Route::get('/regulamin', [StatuteController::class, 'show'])->name('statute');
    Route::put('/regulamin', [StatuteController::class, 'update']);

    Route::get('/administracja', [OperatorController::class, 'admin'])->name('admin');
    Route::put('/administracja/{id}', [OperatorController::class, 'update'])->name('adminUpdate');
    Route::get('/artykuły', [ArticleController::class, 'index'])->name('articles');
    Route::get('/dodaj', [ArticleController::class, 'create'])->name('createArticle');
    Route::post('/dodaj', [ArticleController::class, 'store']);
    Route::get('/zmień/{id}', [ArticleController::class, 'edit'])->name('editArticle');
    Route::put('/zmień/{id}', [ArticleController::class, 'update']);
    Route::delete('/usuń/{id}', [ArticleController::class, 'destroy'])->name('deleteArticle');
    Route::get('/dodaj-płatność', [ShippingController::class, 'create'])->name('createShipping');
    Route::post('/dodaj-płatność', [ShippingController::class, 'store']);
    Route::get('/zmień-płatność/{id}', [ShippingController::class, 'edit'])->name('editShipping');
    Route::put('/zmień-płatność/{id}', [ShippingController::class, 'update']);
    Route::delete('/usuń-płatność/{id}', [ShippingController::class, 'destroy'])->name('deleteShipping');

    Route::middleware(['can:isAdministrator'])->group(function () {
        Route::get('/sadmin', [AdminController::class, 'index'])->name('sadmin');
        Route::get('/sadmin-change-password/{id}', [AdminController::class, 'editPassword'])->name('editPassword');
        Route::put('/sadmin-change-password/{id}', [AdminController::class, 'updatePassword']);
        Route::delete('/sadmin-delete-user/{id}', [AdminController::class, 'destroyUser'])->name('deleteUser');
        Route::get('/sadmin-add-user', [AdminController::class, 'createUser'])->name('createUser');
        Route::post('/sadmin-add-user', [AdminController::class, 'storeUser']);
        Route::delete('/sadmin-delete-all-shippings', [AdminController::class, 'destroyAllShippings'])->name('deleteAllShippings');
        Route::get('/sadmin-show-order/{id}', [AdminController::class, 'showOrder'])->name('showOrder');
        Route::delete('/sadmin-show-order/{id}', [AdminController::class, 'destroyOrder']);
        Route::delete('/sadmin-delete-all-orders', [AdminController::class, 'destroyAllOrders'])->name('deleteAllOrders');
    });
//    Route::get('/dodaj', [ArticleController::class, 'create'])->name('createArticle')->middleware('can:isOperator');
});


//Route::get('/home', [OperatorController::class, 'index'])->name('home');
