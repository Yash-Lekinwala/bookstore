<?php

use App\Http\Controllers\ShopController;
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

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/ajax-get-products', [ShopController::class, 'ajax_get_products'])->name('ajax-get-products');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::get('/product/{product_long_id}', [ShopController::class, 'product_page'])->name('product-page');
Route::post('/add-to-cart', [ShopController::class, 'ajax_add_to_cart'])->name('add-to-cart');
Route::post('/remove-cart-item/{id}', [ShopController::class, 'ajax_remove_cart_item'])->name('remove-cart-item');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [ShopController::class, 'place_order'])->name('place-order');
Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
