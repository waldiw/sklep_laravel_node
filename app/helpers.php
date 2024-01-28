<?php

use App\Mail\ConfirmMail;
use App\Models\Article;
use App\Models\Orders;
use App\Models\Parameters;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

/**
 * helpers from cart with OrderController.
 *
 */
function totalCart()
{

    $totalCart = 0;
    if(Cookie::get('shopping_cart'))
    {
        $cookieData = stripslashes(Cookie::get('shopping_cart'));
        $cartData = json_decode($cookieData, true);
        //$totalCart = count($cartData);
        foreach ($cartData as $key => $value)
        {
            $article = Article::findOrFail($key);
            $totalCart += $article['price'] * $value;
        }
    }
    return $totalCart;
}
/**
 * helpers from cart with OrderController.
 *
 */
function cart()
{
    $cart = [];

    if (Cookie::get('shopping_cart'))
    {
        $cookieData = stripslashes(Cookie::get('shopping_cart'));
        $cartData = json_decode($cookieData, true);

        foreach ($cartData as $key => $value)
        {
            $article = Article::findOrFail($key);
            $subtotal = $article->price * $value;

            $a = [
                'articleName' => $article->name,
                'articlePrice' => $article->price,
                'articleId' => $key,
                'quantity' => $value,
                'subtotal' => $subtotal
            ];
            array_push($cart, $a);
        }

        return $cart;
    }
    return $cart;
}
/**
 * helpers display number two decimal digits and decimal separator coma.
 *
 */
function numberFormat($number)
{
    return number_format($number / 100, 2, ',', ' ');

}

/**
 * helpers from order with OrderController.
 *
 */
function summaryOrder($uuid): string
{
//    $html = '<ul>';
//
//    foreach ($cart as $item) {
//        $html .= '<li>' . $item . '</li>';
//    }
//
//    $html .= '</ul>';

    $orderCart = Orders::where('uuid', $uuid)->first()->carts; // pobiera zamówienie numer uuid  i z niego pozycje koszyka

    $table = '<table id="orderTable" class="orderTable">
            <thead>
            <tr class="tableHead">
                <th>Nazwa produktu</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Wartość</th>
            </tr>
            </thead>
            <tbody id="tableBody">';

    foreach ($orderCart as $data)
    {
                $table .= '<tr class="tableRow">
                    <td>' . $data['name'] . '</td>
                    <td>' . numberFormat($data['price']) . ' zł</td>
                    <td>' . $data['quantity'] . '</td>
                    <td class="subtotal alignRight">' . numberFormat($data['price'] * $data['quantity']) . ' zł</td>
                </tr>';
    }

    $table .= '</tbody>
            <tfoot>
                 <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Razem:</td>
                    <td class="basketTotal alignRight">' . numberFormat(totalOrder($orderCart)) . ' zł</td>
                 </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Wysyłka:</td>
                    <td class="shipping alignRight">' . numberFormat(shipping()) . ' zł</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Do zapłaty:</td>
                    <td class="toPay alignRight">' . numberFormat(totalOrder($orderCart) + shipping()) . ' zł</td>
                </tr>
            </tfoot>
        </table>';


    return $table;
}

/**
 * send confirm email to customer and admin.
 *
 */
function confirmMail($uuid)
{
    // send email to customer
    $order = Orders::where('uuid', $uuid)->first(); // pobiera zamówienie numer uuid
    $email = $order->email;
    $body = summaryOrder($uuid); // funkcja z helpers.php
    $subject = 'Zamówienie w e-sklepie OSM Olecko';
    $view = 'emails.confirmEmail';
    Mail::to($email)->send(new ConfirmMail($body, $subject, $view));

    // send email to admin
    $orderId = $order->id;
    $subject = 'Nowe zamówienie w e-sklepie';
    $body = '';
    $email = email(); // funkcja zwraca emaila z parametrów
    $view = '';
    Mail::to($email)->send(new ConfirmMail($body, $subject, $view));
}

//function emailOrder($uuid)
//{
//    $order = Orders::where('uuid', $uuid)->first();
//    return $order->email;
//}

function email()
{
    $param = Parameters::all();
    return $param[0]->email;
}

function account()
{
    $param = Parameters::all();
    return $param[0]->account;
}
//function orderId($uuid)
//{
//    $order = Orders::where('uuid', $uuid)->first(); // pobiera zamówienie numer uuid
//    return $order->id;
//}
function shipping()
{
    $param = Parameters::all();
    return $param[0]->shipping;
}

function totalOrder($cart)
{
    $totalOrder = 0;
    foreach ($cart as $item)
    {
        $totalOrder += $item['price'] * $item['quantity'];
    }

    return $totalOrder;
}
