<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// ------------------- Products -------------------
// Show products grid
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Show single product page
// Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// ------------------- Checkout -------------------
// Show checkout page for a product
Route::get('/checkout/{uuid}', [CheckoutController::class, 'show'])->name('checkout.show');

// Process checkout (charge)
Route::post('/checkout/{uuid}', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout-success/{uuid}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout-failed', [CheckoutController::class, 'failed'])->name('checkout.failed');

// ------------------- Stripe Webhook -------------------
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');
