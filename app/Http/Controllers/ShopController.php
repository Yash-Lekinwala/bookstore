<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {

    }

    public function home()
    {
        $products = Product::all();

        $data['title'] = 'Home - '.env('APP_NAME');
        $data['products'] = $products;

        return view('home', $data);
    }

    public function product_page($product_long_id)
    {

    }

    public function cart()
    {
        $data['title'] = 'Cart - '.env('APP_NAME');

        return view('cart', $data);
    }
}
