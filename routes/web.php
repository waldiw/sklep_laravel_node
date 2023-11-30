<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ArticleController;
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

Route::get('/', function () {
    return view('index');
});

Auth::routes([
    'login' => false,
    'register' => false,
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
    'confirm' => false, // Password confirm']);
]);

Route::get('/loginPanel', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/loginPanel', [App\Http\Controllers\Auth\LoginController::class, 'login']);


Route::middleware(['can:isAdministrator'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/artykuły', [ArticleController::class, 'index'])->name('articles');
    Route::get('/dodaj', [ArticleController::class, 'create'])->name('createArticles');
    Route::post('/dodaj', [ArticleController::class, 'store']);
});


//Route::get('/home', [HomeController::class, 'index'])->name('home');
