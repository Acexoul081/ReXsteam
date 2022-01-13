<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HeaderTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->withoutMiddleware(['auth']);

Route::get('/search', [GameController::class, 'search'])->name('search');

// Route::middleware(['role:Admin'])->group(function(){
    Route::get('/manageGame', [GameController::class, 'manage'])->name('manage_game');
    Route::post('/manageGame', [GameController::class, 'searchManage'])->name('manage_search');
    Route::get('/createGame', [GameController::class, 'create'])->name('add_game');
    Route::post('/createGame', [GameController::class, 'store'])->name('add_game');
    Route::post('/game/{game}', [GameController::class, 'edit'])->name('edit_game');
    Route::put('/game/{game}', [GameController::class, 'update'])->name('update_game');
    Route::delete('/game/{game}', [GameController::class, 'destroy'])->name('delete_game');
// });

Route::get('/game/{id}', [GameController::class, 'show'])->name('detail_game')->middleware('adult');
Route::post('/validateage', [UserController::class, 'sessionAge'])->name('validate_age');

Route::middleware(['role:Member'])->group(function(){
    Route::get('/cart', [CartController::class, 'index'])->name('cart_show');
    Route::post('/cart', [CartController::class, 'insert'])->name('cart_add');
    Route::delete('/cart', [CartController::class, 'delete'])->name('cart_delete');
    
    Route::get('/transaction', [HeaderTransactionController::class, 'index'])->name('get_transaction');
    Route::get('/transaction', [HeaderTransactionController::class, 'create'])->name('add_transaction');
    Route::post('/transaction', [HeaderTransactionController::class, 'store'])->name('store_transaction');
    Route::delete('/transaction', [CartController::class, 'clear'])->name('cancel_transaction');
});

Route::get('/user/{user}', [UserController::class, 'show'])->name('user_show');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user_update');
Route::post('/user/{user}/friend', [UserController::class, 'addFriend'])->name('add_friend');
Route::delete('/user/{user}/friend', [UserController::class, 'cancelFriend'])->name('cancel_friend');
Route::put('/user/{user}/friend', [UserController::class, 'responseFriend'])->name('response_friend');
Route::get('/user/{user}/friend', [UserController::class, 'getFriend'])->name('user_friend');

Route::get('/user/{user}/transaction', [UserController::class, 'getTransaction'])->name('user_transaction');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->withoutMiddleware(['auth']);
