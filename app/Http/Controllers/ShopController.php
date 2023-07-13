<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TempOrder;
use App\Http\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
        if(!$product_long_id)
            return redirect()->route('home');

        $product_data = Product::whereLongId($product_long_id)->first();
        
        $data['title'] = $product_data->title.' - '.env('APP_NAME');
        $data['product_data'] = $product_data;

        return view('product-page', $data);
    }

    public function ajax_get_products(Request $request)
    {
        $search = $request->input('search');

        if(!$search)
        $products = Product::all();
        else
        $products = Product::where('title', 'like', '%'.$search.'%')->orWhere('author', 'like', '%'.$search.'%')->get();

        $output = '';

        foreach($products as $product)
        {
            $output .= View::make('components.product-card', [
                'product' => $product
                ])->render();
        }

        return response()->json([
            'flag' => true,
            'data' => $output
        ]);
    }

    public function cart()
    {
        $session_id = CommonTrait::session_id();

        $rows = TempOrder::whereSessionId($session_id)->get();

        $data['title'] = 'Cart - '.env('APP_NAME');
        $data['rows'] = $rows;

        return view('cart', $data);
    }

    public function ajax_add_to_cart(Request $request)
    {
        $session_id = CommonTrait::session_id();

        $product_long_id = $request->input('product_long_id');
        $quantity = $request->input('quantity');

        $product = Product::whereLongId($product_long_id)->first();
        if(!$product)
        {
            return response()->json([
                'result' => false,
                'message' => 'Sorry! Product is not available for purchase',
            ],422);
        }

        if($quantity > $product->quantity)
        {
            return response()->json([
                'result' => false,
                'message' => $product->quantity == 0 ? 'Sorry! This Product is out of stock':'Sorry! Available Stock is only '.$product->quantity,
            ],422);
        }


        $obj = TempOrder::whereSessionId($session_id)->whereProductId($product->id)->first();
        if(!$obj)
        {
            $obj = new TempOrder;
            $obj->session_id = $session_id;
            $obj->quantity = $request->quantity;
        }
        else{
            $obj->quantity = isset($request->reset) ? $request->quantity : $obj->quantity + $request->quantity;
        }
        $obj->product_id = $product->id;
        $obj->save();

        return response()->json([
            'result' => true,
            'cart_quantity' => TempOrder::whereSessionId($session_id)->get()->sum('quantity'),
            'message' => "Product added in Cart"
        ]);
    }

    public function ajax_remove_cart_item(Request $request, $item_id)
    {
        $session_id = CommonTrait::session_id();
        TempOrder::whereSessionId($session_id)->whereId($item_id)->delete();

        return response()->json([
            'result' => true,
            'cart_quantity' => TempOrder::whereSessionId($session_id)->get()->sum('quantity'),
            'message' => "Product removed from Cart"
        ]);
    }
    
}
