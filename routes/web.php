<?php

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

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/retail', function () {
    return view('retail');
});

Route::get('/wholesale', function () {
    return view('wholesale');
});

Route::get('/cart', function () {
    return view('cart');
})->name('cart');


require __DIR__.'/auth.php';
