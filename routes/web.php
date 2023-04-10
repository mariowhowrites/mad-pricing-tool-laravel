<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerAssetController;
use App\Http\Controllers\ImageUploadPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TemporaryAssetController;
use App\Http\Controllers\VariantPageController;
use App\Http\Livewire\CheckoutSuccess;
use App\Http\Livewire\ExampleComponent;
use App\Http\Middleware\DecryptImageToken;
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

Route::get('/product/{product}', [ProductPageController::class, 'show'])->name('product.show');

Route::get('/product/{product}/{variant}', [VariantPageController::class, 'show'])->name('variant.show');


Route::get('upload', [ImageUploadPageController::class, 'index'])->name('upload');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/checkout/success', CheckoutSuccess::class)->name('checkout.success');


Route::post('/stripe/webhook', [StripeWebhookController::class, 'create']);

Route::get('/stripe/webhook', [StripeWebhookController::class, 'show']);

Route::get('example', ExampleComponent::class);


Route::middleware([DecryptImageToken::class])->group(function () {
    Route::get('/assets/temp', [TemporaryAssetController::class, 'show'])->name('assets.temp');
    Route::get('/assets/customer', [CustomerAssetController::class, 'show'])->name('assets.customer');
});

Route::get('/profile/orders/{order}', [OrderController::class, 'show'])->name('profile.orders.show');

require __DIR__.'/auth.php';
