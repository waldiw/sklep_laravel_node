<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Parameters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class CartController extends Controller
{
    public function index()
    {

        $cart = cart(); // cart() funkcja z helpers.php
        return view('cart')->with('cart_data', $cart);
    }

    public function addToCart(Request $request)
    {

        $prodId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Cookie::get('shopping_cart'))
        {
            $cookieData = stripslashes(Cookie::get('shopping_cart'));
            $cartData = json_decode($cookieData, true);
        } else {
            $cartData = array();
            //Str::uuid()->toString();
            Cookie::queue(Cookie::make('shopping_uuid', Str::uuid()->toString(), 60));
        }

        if(array_key_exists($prodId, $cartData))
        {
            $cartData[$prodId] = $quantity + $cartData[$prodId];
        }
        else
        {
            $cartData[$prodId] = $quantity + 0;
        }

        $itemData = json_encode($cartData);
        Cookie::queue(Cookie::make('shopping_cart', $itemData, 60));
    }

    public function cartLoadByAjax()
    {

        $totalCart = totalCart(); // totalCart() - funkcja z helpers.php
        $param = Parameters::all();
        $shipping = $param[0]->shipping;
        $toPay = $shipping + $totalCart;
        return json_encode(array('totalCart' => $totalCart, 'shipping' => $shipping, 'toPay' => $toPay));

    }

    public function updateCart(Request $request)
    {
        $prodId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cookieData = stripslashes(Cookie::get('shopping_cart'));
        $cartData = json_decode($cookieData, true);

        $cartData[$prodId] = $quantity;
        $itemData = json_encode($cartData);

        Cookie::queue(Cookie::make('shopping_cart', $itemData, 60));

        $article = Article::findOrFail($prodId);
        $subtotal = $article['price'] * $quantity;
        return json_encode(array('subtotal' => $subtotal, 'id' => $prodId));
    }

    public function deleteFromCart(Request $request)
    {
        $prodId = $request->input('product_id');

        $cookieData = stripslashes(Cookie::get('shopping_cart'));
        $cartData = json_decode($cookieData, true);

        unset($cartData[$prodId]);
        $itemData = json_encode($cartData);

        // jeżeli kilka pozycji w koszyku to kasujemy tą pozycję
        if(count($cartData) == 0)
        {
            Cookie::queue(Cookie::forget('shopping_cart'));
        }
        else
        {
            Cookie::queue(Cookie::make('shopping_cart', $itemData, 60));
        }
        //return view('index')->with('cart_data',$cartData);
    }

    public function clearCart()
    {
        Cookie::queue(Cookie::forget('shopping_cart'));
        Cookie::queue(Cookie::forget('shopping_uuid'));
    }
}
