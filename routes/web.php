<?php

use App\Http\Controllers\GameController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', function () {
    return view('home');
})->name('search');

Route::get('/manageGame', [GameController::class, 'manage'])->name('manage_game');

Route::get('/createGame', [GameController::class, 'create'])->name('add_game');
Route::post('/createGame', [GameController::class, 'store'])->name('add_game');

Route::get('/', function () {
    return view('welcome');
});
