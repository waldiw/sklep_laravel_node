<?php

use App\Enums\ShippingType;
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
function totalCart(): float|int
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
function cart(): array
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
function numberFormat($number): string
{
    return number_format($number / 100, 2, ',', ' ');
}

/**
 * helpers from order with OrderController.
 *
 */
function summaryOrder($uuid): string
{
    $order = Orders::where('uuid', $uuid)->first();
    $orderCart = $order->carts; // pobiera zamówienie numer uuid  i z niego pozycje koszyka
    $totlOrder = totalOrder($orderCart);

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
                    <td class="basketTotal alignRight">' . numberFormat($totlOrder) . ' zł</td>
                 </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">' . $order->shipping->name . ':</td>
                    <td class="shipping alignRight">' . numberFormat($order->shipping->shipping) . ' zł</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Do zapłaty:</td>
                    <td class="toPay alignRight">' . numberFormat($order->shipping->shipping + $totlOrder) . ' zł</td>
                </tr>
            </tfoot>
        </table>';
    return $table;
}

function summaryAccount($uuid): string
{
    $account = account();
    $orderId = Orders::where('uuid', $uuid)->first()->id;

    $summary = '<br><p>Należność za zamówienie prosimy przelać na konto Okręgowej Spóldzielni Mleczarskiej w Olecku:</p>
            <p>' . $account . '</p>
            <p>W tytule przelewu proszę wpisać: <b>Należność za zamówienie numer ' . $orderId . ' </b></p>
            <p>Zamówienie zostanie zrealizowane po zaksięgowaniu należności na naszym koncie.</p>
            <p>Wiadmość wygenerowana automatycznie.</p>
            <p>W razie pytań prosimy o kontakt e-mail: ' . email() . '</p>';

    return $summary;
}

function summaryCash($uuid): string
{
    $order = Orders::where('uuid', $uuid)->first();
    $orderId = $order->id;
    $summary = '<br><p>Zamówienie numer <b>' . $orderId . '</b> zostało przyjęte w e-sklepie OSM Olecko.</p>
            <p>Wiadmość wygenerowana automatycznie.</p>
            <p>W razie pytań prosimy o kontakt e-mail: ' . email() . '</p>';

    return $summary;
}

/**
 * send confirm email to customer and admin.
 *
 */
function confirmMail($uuid): void
{
    // send email to customer
    $order = Orders::where('uuid', $uuid)->first(); // pobiera zamówienie numer uuid
    $email = $order->email;
    $body = summaryOrder($uuid); // funkcja z helpers.php

    if($order->shipping->type === ShippingType::PRZELEW)
    {
        $summary = summaryAccount($uuid);
        $body .= $summary;
    }
    else
    {
        $summary = summaryCash($uuid);
        $body .= $summary;
    }

    $subject = 'Zamówienie w e-sklepie OSM Olecko';
    $view = 'emails.confirmEmail';
    Mail::to($email)->send(new ConfirmMail($body, $subject, $view));

    // send email to admin
    $orderId = $order->id;
    $subject = 'Nowe zamówienie w e-sklepie';
    $bodyAdmin = '<p>Masz nowe zamówienie numer: <b>' . $orderId . '</b></p>';
    $email = email(); // funkcja zwraca emaila z parametrów
    $view = 'emails.confirmAdminEmail';
    Mail::to($email)->send(new ConfirmMail($bodyAdmin, $subject, $view));
}

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

function totalOrder($cart): float|int
{
    $totalOrder = 0;
    foreach ($cart as $item)
    {
        $totalOrder += $item['price'] * $item['quantity'];
    }

    return $totalOrder;
}
