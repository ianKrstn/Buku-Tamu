<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'index']);
Route::controller(MainController::class)->prefix('tamu')->name('tamu.')->group(function () {
    Route::post('/create', 'store')->name('store');
    Route::post('/update/{tamu}', 'update')->name('update');
    Route::post('/delete/{tamu}', 'destroy')->name('destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
