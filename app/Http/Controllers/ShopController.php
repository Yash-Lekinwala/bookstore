<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TempOrder;
use App\Http\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use stdClass;

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
    
    public function checkout()
    {
        if(TempOrder::whereSessionId(Session::get('session_id'))->count() == 0)
        return redirect()->route('home');

        $session_id = CommonTrait::session_id();
        $rows = TempOrder::whereSessionId($session_id)->get();
        $total_qty = TempOrder::whereSessionId($session_id)->get()->sum('quantity');

        $data['title'] = 'Checkout - '.env('APP_NAME');
        $data['rows'] = $rows;
        $data['total_qty'] = $total_qty;

        return view('checkout', $data);
    }

    public function place_order(Request $request)
    {
        $session_id = CommonTrait::session_id();
        $rows = TempOrder::whereSessionId($session_id)->get();

        $long_order_id = Str::random(12);

        $order = new Order;
        $order->long_id = $long_order_id;
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->email = $request->input('email');
        $order->address = $request->input('address');
        $order->country = $request->input('country');
        $order->state = $request->input('state');
        $order->city = $request->input('city');
        $order->total_amount = 0;
        $order->save();

        $order_id = $order->id;

        $sub_total = 0;

        foreach($rows AS $row)
        {
            // $product = WebShopProductPropertyOption::find($row->option_id);
            // $quantity = $row->quantity;

            if($row->quantity > $row->product_data->quantity)
                continue;

            $order_detail = new OrderDetail;
            $order_detail->order_id = $order_id;
            $order_detail->product_id = $row->product_data->id;
            $order_detail->title = $row->product_data->title;
            $order_detail->price = $row->product_data->price;
            $order_detail->quantity = $row->quantity;
            $order_detail->sub_total = $row->quantity*$row->product_data->price;
            $tmp_sub_total = $order_detail->sub_total;

            $order_detail->save();

            $remaining_qty = $row->product_data->quantity - $row->quantity;
            Product::where('id', $order_detail->product_id)->update(['quantity' => $remaining_qty]);

            $sub_total += $tmp_sub_total;
        }

        $order->total_amount = $sub_total;
        $order->save();

        TempOrder::whereSessionId($session_id)->delete();

        return response()->json([
            'result' => true,
            'message' => 'order Placed successfully',
        ]);

    }
}
