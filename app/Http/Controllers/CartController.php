<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class CartController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cart = cart(); // cart() funkcja z helpers.php
        return view('cart')->with('cart_data', $cart);
    }

    public function addToCart(Request $request): void
    {
        $prodId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Cookie::get('shopping_cart'))
        {
            $cookieData = stripslashes(Cookie::get('shopping_cart'));
            $cartData = json_decode($cookieData, true);
        } else {
            $cartData = array();
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

    public function cartLoadByAjax(): bool|string
    {
        $totalCart = totalCart(); // totalCart() - funkcja z helpers.php
        return json_encode(array('totalCart' => $totalCart));
    }

    public function updateCart(Request $request): bool|string
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

    public function deleteFromCart(Request $request): void
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
    }

    public function clearCart(): void
    {
        Cookie::queue(Cookie::forget('shopping_cart'));
        Cookie::queue(Cookie::forget('shopping_uuid'));
    }
}
