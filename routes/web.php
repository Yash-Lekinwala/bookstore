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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::get('/product/{product_long_id}', [ShopController::class, 'product_page'])->name('product-page');
