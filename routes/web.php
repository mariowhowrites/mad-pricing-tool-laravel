<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/retail', function () {
    return view('retail');
})->name('retail');

Route::get('/wholesale', function () {
    return view('wholesale');
})->name('wholesale');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout/success', function() {
    return 'great success!';
})->name('checkout.success');

Route::get('/checkout/cancel', function() {
    return 'order canceled!';
})->name('checkout.cancel');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'create']);

Route::get('/stripe/webhook', [StripeWebhookController::class, 'show']);

require __DIR__.'/auth.php';
