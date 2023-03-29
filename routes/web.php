<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageUploadPageController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TemporaryAssetController;
use App\Http\Livewire\ExampleComponent;
use App\Models\Order;
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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/retail', [ProductPageController::class, 'retail'])->name('retail');

Route::get('/wholesale', [ProductPageController::class, 'wholesale'])->name('wholesale');

Route::get('upload', [ImageUploadPageController::class, 'index'])->name('upload');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/checkout/success', function() {
    return 'great success!';
})->name('checkout.success');

Route::get('/checkout/cancel', function() {
    return 'order canceled!';
})->name('checkout.cancel');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'create']);

Route::get('/stripe/webhook', [StripeWebhookController::class, 'show']);

Route::get('example', ExampleComponent::class);

Route::get('/assets/temp', [TemporaryAssetController::class, 'show'])->name('assets.temp');


Route::get('/mailable', function () {
    $order = Order::find(1);
   
    return new App\Mail\OrderCreated($order);
});

require __DIR__.'/auth.php';
