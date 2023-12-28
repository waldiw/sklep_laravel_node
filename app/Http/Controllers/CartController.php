<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class CartController extends Controller
{
    public function index()
    {
        $cart = [];

        if (Cookie::get('shopping_cart'))
        {
            $cookieData = stripslashes(Cookie::get('shopping_cart'));
            $cartData = json_decode($cookieData, true);

            foreach ($cartData as $key => $value)
            {
                $a = [
                    'articleId' => $key,
                    'quantity' => $value
                ];
                array_push($cart, $a);
            }
        }
        return view('index')->with('cart_data',$cart);
    }

    public function addtocart(Request $request)
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

    public function cartloadbyajax()
    {
        if(Cookie::get('shopping_cart'))
        {
            $cookieData = stripslashes(Cookie::get('shopping_cart'));
            $cartData = json_decode($cookieData, true);
            $totalCart = count($cartData);
        }
        else
        {
            $totalCart = '0';
        }
        return json_encode(array('totalCart' => $totalCart));

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
}
