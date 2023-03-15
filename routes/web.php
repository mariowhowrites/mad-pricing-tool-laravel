<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;

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

Route::get('/checkout/success', function() {
    return 'great success!';
})->name('checkout.success');

Route::get('/checkout/cancel', function() {
    return 'order canceled!';
})->name('checkout.cancel');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'create']);

Route::get('/stripe/webhook', [StripeWebhookController::class, 'show']);

require __DIR__.'/auth.php';
